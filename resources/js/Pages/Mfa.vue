<template>
  <Head title="MFA" />
  <div class="text-center mx-auto font-medium text-md">
    <h1>
      Ustaw logowanie dwuetapowe skanując poniższy kod za pomocą aplikacji
      Google Authenticator.
    </h1>
    <h1>
      Jeśli nie jesteś w stanie zeskanować kodu QR, wpisz ręcznie poniższy kod:
    </h1>
    <div class="mt-4">
      <strong>
        {{ secretkey }}
      </strong>
    </div>
    <div class="mt-4 mx-auto">
      <span v-html="QR_Image" class="qrimg"></span>
    </div>
    <h1>
      Jeżeli nie ustawisz weryfikacji dwuetapowej w tym momencie, zalogowanie do
      aplikacji nie będzie możliwe.
    </h1>
    <BreezeButton class="mt-4" @click="submit">Zakończ</BreezeButton>
  </div>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  layout: BreezeGuestLayout,
  props: {
    secretkey: String,
    QR_Image: String,
  },
  components: {
    BreezeButton,
    Head,
  },
  data() {
    return {
      svgExtra: "display:inline-block;",
    };
  },

  methods: {
    submit() {
      if (
        !confirm(
          "Upewnij się, że zachowałeś/aś kod dostępu. Bez niego zalogowanie do aplikacji nie będzie możliwe!"
        )
      )
        return;
      this.$inertia.get("/mfa/confirm");
    },
  },
};
</script>
<style scoped>
.qrimg:first-child{
    display:inline-block;
}
</style>
