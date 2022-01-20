<template>
  <main>
    <div class="container">
      <div class="row justify-content-center warp_title">
        <div class="col-auto">Оплата подписки</div>
      </div>
    </div>
    <div class="warp_middle">
      <div class="d-flex warp_steps justify-content-between align-items-center">
        <span :class="{ active : currentStep ===1 }"> Шаг 1</span>
        <span :class="{ active : currentStep ===2 }">Шаг 2</span>
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
            <div class="contact-date">Mail@mail.ru</div>
            <div class="contact-date">Петр Рафаилович</div>
          </div>
          <div class="col-auto warp_promo_date">
            <p>Пробный период:</p>
            <div class="date">до 01 янв 2022</div>

          </div>

        </div>
        <p>Количество используемых QR терминалов</p>
        <div class="row warp_count">
          <div class="col-auto">
            <button id="button_minus">-</button>
            <input type="text"  onkeypress='validate(event)'  id="num_count"  value="1" title="Qty">
            <button id="button_plus">+</button>
          </div>
          <div class="col warp_text_count">
            В любой момент подпис.  периода Вы сможете докупить QRT сверх кол-ва, которое Вы сейчас выбираете для подписки
          </div>
        </div>
        <p>Выберите тариф на следующий подпис. период</p>
        <div class="row warp_bt_tarif">
          <div class="col"><button class="bt-white disabled" disabled >1 месяц</button></div>
          <div class="col"><button class="bt-white" >3 месяца <span>-10%</span></button></div>
          <div class="col"><button class="bt-white disabled" disabled>1 год <span>-15%</span></button></div>
        </div>
        <div class="warp_price">
          <div class="row justify-content-between">
            <div class="col-auto">
              <div class="itogo">Итого:</div>
              <div class="price">152 240 руб</div>
            </div>
            <div class="col-auto">
              <button class="bt">Перейти к оплате</button>
            </div>
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
      currentStep: 2,
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
  ready: function() {

  },
  methods: {
    goToStep: function(step) {
      this.currentStep = step;
    },
    onSubmit(values) {
      console.log(values, null, 2);
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
  }
}
</script>
