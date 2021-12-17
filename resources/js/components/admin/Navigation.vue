<template>
  <!-- <div> -->
    <div class="sb-sidenav-menu">
      <div class="nav">
          <div class="sb-sidenav-menu-heading">Core</div>
          <a class="nav-link cursor" @click="redirectTo('')">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
          </a>
          <a class="nav-link cursor" @click="redirectTo('teachers-setup')">
              <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
              Teachers Setup
          </a>
          <a class="nav-link cursor" @click="redirectTo('')">
              <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
              Students Setup
          </a>
          <div class="sb-sidenav-menu-heading">Interface</div>
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Payments
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link cursor" @click="redirectTo('students-payment')">Students</a>
                  <a class="nav-link cursor">Teachers</a>
              </nav>
          </div>
          <a class="nav-link collapsed d-none" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
              Pages
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
          </a>
          <div class="collapse d-none" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                      Authentication
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="login.html">Login</a>
                          <a class="nav-link" href="register.html">Register</a>
                          <a class="nav-link" href="password.html">Forgot Password</a>
                      </nav>
                  </div>
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                      Error
                      <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="401.html">401 Page</a>
                          <a class="nav-link" href="404.html">404 Page</a>
                          <a class="nav-link" href="500.html">500 Page</a>
                      </nav>
                  </div>
              </nav>
          </div>
          <div class="sb-sidenav-menu-heading ">Wallet</div>
          <a class="nav-link " href="/admins/heygo-wallet">
              <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
              Heygo Wallet
          </a>
          <a class="nav-link" href="/admins/teacher-wallet">
              <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
              Teachers Wallet
          </a>
      </div>
    </div>
  <!-- </div> -->
</template>

<script>
export default {
  methods: {
    redirectTo (r) {
      this.$router.push({ path: '/' + r, });
    }
  }
}
</script>

<style>

</style>