<template>
  <div class="card rounded-0 bg-transparent border-0">
      <div class="card-body pb-5">
        <h2 class="mb-4">Panel Settings</h2>
        <div class="row">
          <div class="col-lg-3">
            <transition name="slide-fade">
              <div class="card cursor w-100" @click="redirectToBadge" style="width: 18rem;">
                <div class="card-body">
                  <h3 class="card-title"><i class="fas fa-certificate text-warning"></i> Badges</h3>
                  <p class="card-text"><small class="text-muted">Some qualities of a good teacher include skills in communication, listening, collaboration, adaptability, empathy and patience.</small></p>
                </div>
              </div>
            </transition>
          </div>
          <!-- <b-button @click="makeToast()">Show Toast</b-button>
          <Toasts
            :show-progress="true"
            :rtl="false"
            :max-messages="5"
            :time-out="3000"
            :closeable="true"
          ></Toasts> -->
        </div>
        
      </div>
  </div>
</template>

<script>
export default {
  name: 'BadgesSetup',
  data(){
    return {
      baseurl: document.querySelector('meta[name="base-url"]').getAttribute('content'),
    }
  },
  methods: {
    redirectToBadge () {
     this.$router.push(
        {
          path: '/badges',
        }
     )
    }
  }
}
</script>

<style>

</style>