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
              <Field name="pin" type="text" placeholder="PIN-код" class="input-control"  :rules="validatePin" v-show="showPin"/>
              <Field name="pin" type="password" class="input-control" placeholder="PIN-код" v-show="!showPin"/>
              <ErrorMessage class="input-error" name="pin" />
              <div class="buttonShowPass" @click="showPassBt">

                <div class="hidePass" v-show="!showPin">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.00977 3.23535L16.309 16.7645" stroke="black" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.2289 12.275C11.6255 12.8235 10.8289 13.1098 10.0144 13.071C9.19986 13.0321 8.43411 12.6714 7.88558 12.068C7.33705 11.4646 7.05066 10.668 7.08941 9.8535C7.12817 9.03897 7.48888 8.27319 8.09222 7.72461" stroke="black" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.00884 5.43262C2.87489 7.01965 1.55078 9.99922 1.55078 9.99922C1.55078 9.99922 4.01064 15.5333 10.1603 15.5333C11.6011 15.5448 13.024 15.2129 14.3111 14.5651" stroke="black" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16.3567 13.1595C18.0326 11.6584 18.7697 10.0001 18.7697 10.0001C18.7697 10.0001 16.3098 4.46486 10.1602 4.46486C9.62755 4.46399 9.09577 4.50729 8.57031 4.59432" stroke="black" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10.7383 6.97949C11.3918 7.10498 11.987 7.43899 12.4347 7.93141C12.8823 8.42382 13.1582 9.0481 13.221 9.7106" stroke="black" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="showPass" v-show="showPin">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.1608 4.46387C4.01112 4.46387 1.55127 9.99914 1.55127 9.99914C1.55127 9.99914 4.01112 15.5332 10.1608 15.5332C16.3104 15.5332 18.7702 9.99914 18.7702 9.99914C18.7702 9.99914 16.3104 4.46387 10.1608 4.46387Z" stroke="#171717" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10.1608 13.0744C11.8589 13.0744 13.2356 11.6978 13.2356 9.99962C13.2356 8.30145 11.8589 6.9248 10.1608 6.9248C8.46258 6.9248 7.08594 8.30145 7.08594 9.99962C7.08594 11.6978 8.46258 13.0744 10.1608 13.0744Z" stroke="#171717" stroke-width="1.22993" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <button type="submit" class="bt"><span
                  v-show="loading"
                  class="spinner-border spinner-border-sm"
              ></span>Дальше</button>
            </div>
          </div>
          <div class="row mt-5 justify-content-center" v-if="error !== ''">
            <div class="col-auto">
              <div class="alert alert-danger" role="alert">
                <div  v-for="(value,key) in error" :key="key">{{value}}</div>
              </div>
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
              <span v-if="showDate">
              Действует <br>
              до</span> {{subscription_expiration_date}}
            </div>

          </div>

        </div>
        <p>Число терминалов к оплате</p>
        <div class="row warp_count">
          <div class="col-auto">
            <input type="text"  onkeypress='validate(event)'  id="num_count"  v-bind:value="unpaid_qrt" title="Qty" disabled>
          </div>

        </div>
        <p>Выберите тариф</p>
        <div class="row warp_bt_tarif">
          <div class="col-12 col-sm" v-tooltip="tarif.tooltip"  v-for="tarif in tarifs" :key="tarif.hash" v-bind:id="tarif.id">
            <button  class="bt-white js__btn_tarif" v-bind:class="{ 'active': tarif.active, 'disabled':!tarif.is_enable }"  :disabled="!tarif.is_enable"  :id="'btn__'+tarif.id" @click="setPrice(tarif.id )" >{{tarif.name}} <div v-html="tarif.sale"></div> </button>
            <div class="tarif_date"><span v-if="showDate">Действует до <br></span>{{tarif.subscription_expiration_date}} </div>
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
      showPin:false,
      loading:false,
      showDate:true,
      error:'',
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
    showPassBt(){
      this.showPin=!this.showPin;
    },
    goToStep: function(step) {
      this.currentStep = step;
    },
    onSubmit(values) {
      this.loading=true;
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
        this.loading=false;
        let data = response.data;
        console.log(data);
        if (data.non_field_errors!==undefined) {
          this.error = data.non_field_errors;
          //alert(data.non_field_errors);
        }else if (data.pin!==undefined) {
            this.error = data.pin;
        } else {
          /*mode 2*/
          //data.mode=3;
          /**/
          switch (data.mode) {
            case 1:
              this.title_h1 = 'Новая подписка';
              break;
            case 2:
              this.title_h1 = 'Продление подписки';
              break;
            case 3:
              this.title_h1 = 'Расширение подписки';
              break;
          }

          if(data.subscription_expiration_date !== null){
            const now = new Date(data.subscription_expiration_date);
            this.subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(now);
          } else {
            this.showDate= false;
            this.subscription_expiration_date = 'Нет активной подписки.'
          }

          this.step_2_email = data.email;
          this.step_2_first_name = data.first_name;
          this.step_2_last_name = data.last_name;
          this.unpaid_qrt = data.unpaid_qrt;


          for (let k in data.tariff_rates) {
            switch (data.tariff_rates[k].name) {
              case 'Подписка на месяц':
                data.tariff_rates[k].active = false;
                data.tariff_rates[k].name = '1 месяц';
                data.tariff_rates[k].tooltip = '';

                data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                if (!data.tariff_rates[k].is_enable) {
                  data.tariff_rates[k].tooltip = 'Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                }
                break;
              case 'Подписка на квартал':
                data.tariff_rates[k].name = '3 месяца';
                data.tariff_rates[k].active = true;
                data.tariff_rates[k].sale = '<span>-10%</span>';
                this.allPrice = data.tariff_rates[k].amount;
                this.selectedTarif = data.tariff_rates[k];
                data.tariff_rates[k].tooltip = '';
                data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                if (!data.tariff_rates[k].is_enable) {
                  data.tariff_rates[k].tooltip = 'Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                }
                break;
              case 'Подписка на год':
                data.tariff_rates[k].active = false;

                data.tariff_rates[k].name = '1 год';
                data.tariff_rates[k].sale = '<span>-15%</span>';
                data.tariff_rates[k].subscription_expiration_date = new Intl.DateTimeFormat("ru", {dateStyle: "long"}).format(new Date(data.tariff_rates[k].subscription_expiration_date));
                if (!data.tariff_rates[k].is_enable) {
                  data.tariff_rates[k].tooltip = 'Остальные тарифы для новых терминалов недоступны, т.к. терминалы будут добавлены к текущей подписке на условиях текущей подписки';
                }
                break;
            }
          }

          this.tarifs = data.tariff_rates;

          //this.tarifs=data.tariff_rates;
          this.goToStep(2);
        }

        }).catch((error) => {
            console.log(error);
          });



    },
    validateEmail(value) {
      this.error='';
      // if the field is empty
      if (!value) {
        return 'E-mail не заполнен';
      }
      // if the field is not a valid email
      const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
      if (!regex.test(value)) {
        return 'Не является email';
      } else {
        let myarr = value.split("@");
        if(myarr[0].length > 128 ||  myarr[1].length > 128){
          return 'Недопустимый формат email';
        } else {
          let firstPos = myarr[0].indexOf('.');
          if(firstPos !== -1){
            return 'email не может начинатся с "."';
          } else{
            /*let lastPos = myarr[1].lastIndexOf('.');
            console.log(lastPos);
            if(lastPos !== -1){
              return 'email не может оканчиваться  "."';
            }*/
          }

        }

      }

      // All is good
      return true;
    },
    validatePin(value) {

      if(value !== undefined){
        if( value.match(/[^0-9'".]/)){
          return 'Pin-код должен состоять только из цифр';
        }
        console.log(value);
        this.error='';
        // if the field is empty

        if(value.length!==5){
          return 'Pin-код должен состоять из 5 символов';
        }
        if (!value) {
          return 'Введите Pin-код';
        }
        return true;
      }
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
        console.log(response.data);
        let data = response.data.results;
        this.tmpImg = data.qr_img;
        this.warp_qr='<a href="'+data.qr_link+'" target="_blank"> <img src="'+data.qr_img+'" alt=""></a><p class="qr_text">Для оплаты отсканируйте QR-код или нажмите на него, если Вы открыли эту страницу на смартфоне</p>' +
            '<button class="btn_sahre js__btn_sahre_click" ><svg width="25" height="19" viewBox="0 0 25 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.382699 16.1262C0.0780223 15.8103 0.00671726 15.3361 0.204999 14.9445L1.16956 13.0396C3.45243 8.53127 8.07649 5.68963 13.1299 5.68964H13.6041C13.6387 4.93836 13.6834 4.18744 13.7381 3.43706L13.8313 2.15744C13.9072 1.11681 15.0675 0.53509 15.9468 1.09689C18.831 2.93989 21.3385 5.31463 23.3354 8.09455L23.9626 8.96759C24.2208 9.32712 24.2208 9.81137 23.9626 10.1709L23.3354 11.0439C21.3385 13.8239 18.831 16.1986 15.9468 18.0416C15.0675 18.6034 13.9072 18.0217 13.8313 16.981L13.7381 15.7014C13.6727 14.8053 13.6218 13.9084 13.5851 13.0111C10.6291 12.9257 7.67669 13.5224 4.96331 14.7747L1.55717 16.3467C1.15865 16.5307 0.687376 16.4422 0.382699 16.1262ZM3.43279 13.2095L4.09901 12.902C7.41432 11.3719 11.0519 10.7259 14.6615 11.0031C15.1871 11.0435 15.5977 11.4739 15.6133 12.0009C15.6483 13.1852 15.7089 14.3691 15.7951 15.5515L15.8026 15.6539C18.0623 14.0566 20.0427 12.0925 21.6603 9.84063L21.8553 9.56924L21.6603 9.29785C20.0427 7.04595 18.0623 5.08192 15.8026 3.48463L15.7951 3.58701C15.7182 4.64247 15.6616 5.69905 15.6255 6.75614C15.6065 7.31164 15.1506 7.75214 14.5948 7.75214L13.1299 7.75214C9.14609 7.75213 5.47763 9.83925 3.43279 13.2095Z" fill="black"/></svg>Поделиться QR-кодом</button>';


        const  ws = new WebSocket("wss://stage.wapiserv.qrm.ooo/ws/qr-code?api_key=ViVuB0oA.Fs0pQYpduk99zxZoeZR6gVhFx8itg4yP");

        ws.addEventListener('open', () =>{
          ws.send(JSON.stringify({
            "command": "get_qr_status",
            "body": {"operation_uuid": data.operation_id }
          }));
          ws.onmessage = e => {
            console.log(e);
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
