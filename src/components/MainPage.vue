<template>
  <main>
    <div class="container">
      <div class="row justify-content-center warp_title">
        <div class="col-auto">{{title_h1}}</div>
      </div>
    </div>
    <div class="warp_middle">
      <div class="d-flex warp_steps justify-content-between align-items-center">
        <span :class="{ active : currentStep >=1 }"> Шаг 1</span>
        <span :class="{ active : currentStep >=2 }">Шаг 2</span>
        <span :class="{ active : currentStep ===3 }">Шаг 3</span>
      </div>
      <div class="warp_data" id="step1" v-if="currentStep == 1">
        <div class="row"><div class="col f-bold fz-18 mb-4 text-center">Введите данные, указанные при регистрации аккаунта</div></div>
        <Form @submit="onSubmit">
          <div class="row flex-column align-items-center warp_statps_1">
            <div class="col-auto position-relative">
              <Field name="email" type="email" placeholder="E-mail" class="input-control"  :rules="validateEmail" />
              <ErrorMessage class="input-error" name="email" />
            </div>

            <div class="col-auto position-relative">
              <Field name="pin" type="text" placeholder="PIN-код" class="input-control"  :rules="validatePin" />
              <ErrorMessage class="input-error" name="pin" />
            </div>
            <div class="col-auto">
              <button type="submit" class="bt">Дальше</button>
            </div>
          </div>
        </Form>
      </div>





      <div class="warp_data" id="step2" v-if="currentStep == 2">
        <div class="row warp_contact-data justify-content-between">
          <div class="col-auto">
            <p>Учетная запись</p>
            <div class="contact-date">{{step_2_email}}</div>
            <div class="contact-date">{{step_2_first_name}} {{step_2_last_name}}</div>
          </div>
          <div class="col-auto warp_promo_date">
            <p>Статус подписки</p>
            <div class="date">
              Действует <br>
              до {{subscription_expiration_date}}
            </div>

          </div>

        </div>
        <p>Число терминалов к оплате</p>
        <div class="row warp_count">
          <div class="col-auto">
            <input type="text"  onkeypress='validate(event)'  id="num_count"  v-bind:value="unpaid_qrt" title="Qty">
          </div>

        </div>
        <p>Выберите тариф</p>
        <div class="row warp_bt_tarif">
          <div class="col-12 col-sm" v-tooltip="tarif.tooltip"  v-for="tarif in tarifs" :key="tarif.hash" v-bind:id="tarif.id">
            <button  class="bt-white js__btn_tarif" v-bind:class="{ 'active': tarif.active, 'disabled':!tarif.is_enable }"  :disabled="!tarif.is_enable"  :id="'btn__'+tarif.id" @click="setPrice(tarif.id )" >{{tarif.name}} <div v-html="tarif.sale"></div> </button>
            <div class="tarif_date">Действует до <br>{{tarif.subscription_expiration_date}} </div>
          </div>
<!--          <div class="col"><button class="bt-white" >3 месяца <span>-10%</span></button></div>
          <div class="col"><button class="bt-white disabled" disabled>1 год <span>-15%</span></button></div>-->
        </div>
        <div class="warp_price">
          <div class="row justify-content-between align-items-start">
            <div class="col-auto">
              <div class="itogo">Итого:</div>
              <div class="price">{{ allPrice }} руб</div>
            </div>
            <div class="col-auto">
              <button class="bt" @click="nextStepPay">Перейти к оплате</button>
              <div class="info_pay">При переходе на предыдущий шаг, все данные введённые ранее, потеряются</div>
            </div>
          </div>
        </div>
      </div>


      <div class="warp_data" id="step3" v-if="currentStep == 3">
        <div class="row warp_contact-data justify-content-between">
          <div class="col-lg-6">
            <div class="warp_contact-data">
            <p>Учетная запись</p>
              <div class="contact-date">{{step_2_email}}</div>
              <div class="contact-date">{{step_2_first_name}} {{step_2_last_name}}</div>
            </div>
            <p>Число терминалов к оплате</p>
            <div class="row warp_count">
              <div class="col-auto">
                <div  class="num_count">{{unpaid_qrt}}</div>
              </div>
            </div>
            <div class="warp_selected_tarif">
              <p>Тариф</p>
              {{ this.selectedTarif.name }}
            </div>
            <div class="warp_price ">
              <div class="row justify-content-between">
                <div class="col-auto">
                  <div class="itogo">Итого:</div>
                  <div class="price">{{ allPrice }} руб</div>
                </div>
              </div>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="img_qr" v-html="warp_qr"  @click="handleClick"></div>
          </div>
        </div>
      </div>

    </div>
    <Contact/>
  </main>
</template>

<script>
import Contact from '../components/Contact'
import { Field, Form, ErrorMessage } from 'vee-validate';
import axios from 'axios';



function __Share(data){

  if (navigator.share) {
    navigator.share(data)
        .then((succ) => {
          if (succ) {
            alert(succ);
          }
        })
        .catch((err) => {
          alert(err);
        })
  } else {
    alert('method not supported');

  }
}
export default {
  name: 'MainPage',
  components: {
    Field,
    Form,
    ErrorMessage,
    Contact
  },
  data() {

    return{
      tmpImg:'',
      attrs:{},
      warp_qr:'',
      title_h1:'Оплата подписки',
      step_2_email:'',
      step_2_first_name:'',
      step_2_last_name:'',
      subscription_expiration_date:'',
      unpaid_qrt:'',
      tarifs:[],
      allPrice:'',
      selectedTarif:'',

      currentStep: 1,
    }

/*    step1: {
      name: '',
      email: ''
    },
    step2: {
      city: '',
      state: ''
    }*/
  },

  methods: {
    goToStep: function(step) {
      this.currentStep = step;
    },
    onSubmit(values) {
/*      console.log(values, null, 2);
      values.email='dev@qrm.ooo';
      values.pin=11111;*/
      axios.post(
       '/post.php',
      {
          url:'subscription-data',
          email: values.email,
          pin: values.pin,
          },

        ).then((response) => {
          let data = response.data;
        /*mode 2*/
          //data.mode=3;
        /**/
          switch (data.mode){
            case 1:
              this.title_h1='Новая подписка';
              break;
            case 2:
              this.title_h1='Продление подписки';
              break;
            case 3:
              this.title_h1='Расширение подписки';
              break;
          }

            const now = new Date(data.subscription_expiration_date);
            this.subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(now);

            this.step_2_email=data.email;
            this.step_2_first_name=data.first_name;
            this.step_2_last_name=data.last_name;
            this.unpaid_qrt=data.unpaid_qrt;


            for(let k in data.tariff_rates){
              switch (data.tariff_rates[k].name){
                case 'Подписка на месяц':
                  data.tariff_rates[k].active=false;
                  data.tariff_rates[k].name='1 месяц';
                  data.tariff_rates[k].tooltip ='';

                  data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                  if(!data.tariff_rates[k].is_enable){
                    data.tariff_rates[k].tooltip ='Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                  }
                  break;
                case 'Подписка на квартал':
                  data.tariff_rates[k].name='3 месяца';
                  data.tariff_rates[k].active=true;
                  data.tariff_rates[k].sale='<span>-10%</span>';
                  this.allPrice = data.tariff_rates[k].amount;
                  this.selectedTarif = data.tariff_rates[k];
                  data.tariff_rates[k].tooltip ='';
                  data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                  if(!data.tariff_rates[k].is_enable){
                    data.tariff_rates[k].tooltip ='Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                  }
                  break;
                case 'Подписка на год':
                  data.tariff_rates[k].active=false;

                  data.tariff_rates[k].name='1 год';
                  data.tariff_rates[k].sale='<span>-15%</span>';
                  data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                  if(!data.tariff_rates[k].is_enable){
                    data.tariff_rates[k].tooltip ='Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                  }
                  break;
              }
            }

            this.tarifs=data.tariff_rates;

            //this.tarifs=data.tariff_rates;



        }).catch((error) => {
            console.log(error);
          });


      this.goToStep(2);
    },
    validateEmail(value) {
      // if the field is empty
      if (!value) {
        return 'E-mail не заполнен';
      }
      // if the field is not a valid email
      const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
      if (!regex.test(value)) {
        return 'This field must be a valid email';
      }
      // All is good
      return true;
    },
    validatePin(value) {
      // if the field is empty
      if (!value) {
        return 'Введите Pin-код';
      }
      return true;
    },
    setPrice(id){

      for (let i in this.tarifs){
        if(this.tarifs[i].id === id){
          if(this.tarifs[i].is_enable){
            this.allPrice = this.tarifs[i].amount;
            this.selectedTarif = this.tarifs[i];
          } else {
            return;
          }
        }
      }

      const items = document.querySelectorAll('.js__btn_tarif')
      Array.from(items).forEach(item => {
        item.classList.remove('active')
      })
      let d = document.getElementById('btn__'+id);
      d.className += " active";


    },
    qrShow: function (){
      axios.post(
          '/post.php',
          {
            url:'qr_code',
            summ: this.allPrice,
          },

      ).then((response) => {
        if(response.data.non_field_errors!==undefined){
          alert(response.data.non_field_errors.join('\n'))
        }
        console.log(response.data.non_field_errors);
        let data = response.data.results;
        this.tmpImg = data.qr_img;
        this.warp_qr='<a href="'+data.qr_link+'" target="_blank"> <img src="'+data.qr_img+'" alt=""></a><p class="qr_text">Для оплаты отсканируйте QR-код или нажмите на кнопку, чтобы получить платёжную ссылку</p>' +
            '<button class="btn_sahre js__btn_sahre_click" ><svg width="25" height="19" viewBox="0 0 25 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.382699 16.1262C0.0780223 15.8103 0.00671726 15.3361 0.204999 14.9445L1.16956 13.0396C3.45243 8.53127 8.07649 5.68963 13.1299 5.68964H13.6041C13.6387 4.93836 13.6834 4.18744 13.7381 3.43706L13.8313 2.15744C13.9072 1.11681 15.0675 0.53509 15.9468 1.09689C18.831 2.93989 21.3385 5.31463 23.3354 8.09455L23.9626 8.96759C24.2208 9.32712 24.2208 9.81137 23.9626 10.1709L23.3354 11.0439C21.3385 13.8239 18.831 16.1986 15.9468 18.0416C15.0675 18.6034 13.9072 18.0217 13.8313 16.981L13.7381 15.7014C13.6727 14.8053 13.6218 13.9084 13.5851 13.0111C10.6291 12.9257 7.67669 13.5224 4.96331 14.7747L1.55717 16.3467C1.15865 16.5307 0.687376 16.4422 0.382699 16.1262ZM3.43279 13.2095L4.09901 12.902C7.41432 11.3719 11.0519 10.7259 14.6615 11.0031C15.1871 11.0435 15.5977 11.4739 15.6133 12.0009C15.6483 13.1852 15.7089 14.3691 15.7951 15.5515L15.8026 15.6539C18.0623 14.0566 20.0427 12.0925 21.6603 9.84063L21.8553 9.56924L21.6603 9.29785C20.0427 7.04595 18.0623 5.08192 15.8026 3.48463L15.7951 3.58701C15.7182 4.64247 15.6616 5.69905 15.6255 6.75614C15.6065 7.31164 15.1506 7.75214 14.5948 7.75214L13.1299 7.75214C9.14609 7.75213 5.47763 9.83925 3.43279 13.2095Z" fill="black"/></svg>Поделиться QR-кодом</button>';


        const  ws = new WebSocket("wss://wapiserv.qrm.ooo/ws/qr-code?api_key=J8LUjbGJ.UBZksq5n9O443l3Nw93rbqSdDjIb0ZpZ");

        ws.addEventListener('open', () =>{
          ws.send(JSON.stringify({
            "command": "get_qr_status",
            "body": {"operation_uuid": data.operation_id }
          }));
          ws.onmessage = e => {                //подписка на получение данных по вебсокету
            const message = JSON.parse(e.data);
            if(message.results.operation_status_code == 5){
              this.warp_qr='<img src="/images/qr_sacces.png" alt="Ваша подписка активирована"><p class="qr_text_sacces">Ваша подписка активирована</p>' +
                  '<button  class="btn_sahre js__finish_click" >Завершить</button>';
            } else if(message.results.operation_status_code == 6){
              this.warp_qr='<img src="/images/qr_error.png" alt="Ошибка оплаты"><p class="qr_text_sacces">При оплате произошла ошибка, попробуйте еще раз</p>' +
                  '<button class="btn_sahre js__toRetry_click">Повторить попытку</button>';
            }
            console.log(message);
          };
        })


      }).catch((error) => {
        console.log(error);
      });
    },
    nextStepPay: function (){
      this.qrShow();
      this.goToStep(3);
    },
    handleClick(e) {
      if (e.target.matches('.js__btn_sahre_click')) {

        let img =this.tmpImg;
        let summ = this.allPrice;
        const data = {
          title: 'Qr code  на оплату '+summ+'.руб',
          text: 'QR код сформирован https://faosp.ru/',
          url: img
        }
        __Share(data);
        /*const data = {
          title: 'Qr code  на оплату '+summ+'.руб',
          text: 'QR код сформирован https://faosp.ru/',
          url: img
        };*/
       /* const data = {
          title: "this.title",
          text: "this.text",
          url:"https://github.com/GabrielBibiano/vue-navigator-share/blob/master/NavigatorShare.vue"
        };
          if (navigator.share) {
              navigator.share(data)
                  .then((succ) => {
                    if (succ) {
                      alert(succ);
                    }
                  })
                  .catch((err) => {
                    alert(err);
                  })
          } else {
            alert('method not supported');
            if (this.onError) {
              this.onError('method not supported');
            }
          }*/

      }

      if(e.target.matches('.js__finish_click')){
        this.warp_qr='';
        this.title_h1='Оплата подписки';
        this.step_2_email='';
        this.step_2_first_name='';
        this.step_2_last_name='';
        this.subscription_expiration_date='';
        this.unpaid_qrt='';
        this.tarifs=[];
        this.allPrice='';
        this.selectedTarif='';
        this.currentStep= 1;
      }

      if(e.target.matches('.js__toRetry_click')){
        this.qrShow();
      }

    }

  },

}
</script>
