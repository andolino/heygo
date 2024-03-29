/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import Form from './Form'
import HomeSlider from './components/HomeSlider.vue';
import AvailableLesson from './components/AvailableLesson.vue';
import SignupFormTeacher from './components/SignupFormTeacher.vue';
import SignupFormStudent from './components/SignupFormStudent.vue';
import TeacherAcctSettings from './components/TeacherAcctSettings.vue';
import TeacherProfileSettings from './Display/Content/TeacherProfileSettings.vue';
import StudentAcctSettings from './components/StudentAcctSettings.vue';
import TeacherFeeds from './components/TeacherFeeds.vue';
import StudentFeeds from './components/StudentFeeds.vue';
import FetchFeeds from './components/FetchFeeds.vue';
import TeachersProfile from './components/TeachersProfile.vue';
import StudentHomework from './components/StudentHomework.vue';
import StudentPaymentMethods from './components/StudentPaymentMethods.vue';
import TeacherPaymentMethods from './components/TeacherPaymentMethods.vue';
import TeacherUpcomingLesson from './components/TeacherUpcomingLesson.vue';
import StudentUpcomingLesson from './components/StudentUpcomingLesson.vue';
import TeachersNotifications from './components/TeachersNotifications.vue';
import TeachersLibrary from './components/TeachersLibrary.vue';
import TeachersCalendar from './components/TeachersCalendar.vue';
import TeachersPurchaseHistory from './components/TeachersPurchaseHistory.vue';
import ChatPanel from './components/ChatPanel.vue';
import TeacherInformation from './components/TeacherInformation.vue';
import WorkbookShop from './components/WorkbookShop.vue';
import DashboardPanel from './components/admin/DashboardPanel.vue';
import Navigation from './components/admin/Navigation.vue';
import StudentsPayment from './components/admin/StudentsPayment.vue';
import TeachersPayment from './components/admin/TeachersPayment.vue';
import HeygoWallet from './components/admin/HeygoWallet.vue';
import TeachersSetup from './components/admin/TeachersSetup.vue';
import TeacherMainProfile from './Display/Content/TeacherMainProfile.vue';
import TeachersWorkbooks from './Display/Content/TeachersWorkbooks.vue';
import WorkbookMaterials from './Display/Content/WorkbookMaterials.vue';
import AnswerMaterials from './Display/Content/AnswerMaterials.vue';

import { BootstrapVue, IconsPlugin, BCard } from 'bootstrap-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import swal from 'sweetalert2';
import helpers from './helpers';
import VueBootstrapToasts from "vue-bootstrap-toasts";
import VueRouter from 'vue-router';

import SettingsPanel from './components/admin/SettingsPanel.vue';
import UpperNavigation from './components/admin/UpperNavigation.vue';
import BadgesSetup from './components/admin/settings-panel/BadgesSetup.vue';
import TeacherInformationMain from './components/TeacherInformationMain.vue';
import TeachingStrategies from './components/TeachingStrategies.vue';
import TeachingStrategiesCard from './Display/Content/TeachingStrategiesCard.vue';
import StrategyFilter from './Display/Functions/StrategyFilter.vue';
import Embed from 'v-video-embed';
import VCalendar from 'v-calendar';
import VueDraggableResizable from 'vue-draggable-resizable'
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'


// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

//view dropzone
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

//resizable
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'



window.Form = Form
window.Swal = swal

const plugin = {
  install () {
    Vue.helpers = helpers
    Vue.prototype.$helpers = helpers
  }
}



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueSweetalert2)
Vue.use(plugin)
Vue.use(VueBootstrapToasts)
Vue.use(VueRouter)
Vue.use(Embed)
Vue.component('BCard', BCard)
Vue.component('todo-component', require('./components/TodoComponent.vue').default );
Vue.use(VCalendar);
Vue.component('vue-draggable-resizable', VueDraggableResizable)
// Register components in your 'main.js'
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)
// Vue.component('b-carousel', '');


const routes = [
	//admin router
	{ path: '/', name: 'dashboard', component: DashboardPanel },
	{ path: '/teachers-setup', name: 'teachers-setup', component: TeachersSetup },
	{ path: '/students-payment', name: 'students-payment', component: StudentsPayment },
	{ path: '/teachers-payment', name: 'teachers-payment', component: TeachersPayment },
	{ path: '/heygo-wallet', name: 'heygo-wallet', component: HeygoWallet },
	{ path: '/settings-panel', name: 'settings-panel', component: SettingsPanel },
	{ path: '/badges', name: 'badges-panel', component: BadgesSetup },
	// { path: '/admins/badges', name: 'badges-panel', component: BadgesSetup }
];

const router = new VueRouter({
	routes,
	// mode: 'history'
});

Vue.filter('toCurrency', function (value) {
	if (typeof value !== "number") {
			return value;
	}
	var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'PHP',
			minimumFractionDigits: 0
	});
	return formatter.format(value);
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: '#app',
	router: router,
	components: {
		// 'todo-component':
		'home-slider'							  : HomeSlider,
		'available-lesson' 				  : AvailableLesson,
		'signup-form-student'   	  : SignupFormStudent,
		'signup-form-teacher'   	  : SignupFormTeacher,
		'student-acct-settings' 	  : StudentAcctSettings,
		'teacher-acct-settings' 	  : TeacherAcctSettings,
		'teacher-profile-settings' 	: TeacherProfileSettings,
		'fetch-feeds'							  : FetchFeeds,
		'teacher-feeds'						  : TeacherFeeds,
		'student-homework'				  : StudentHomework,
		'teachers-profile'				  : TeachersProfile,
		'student-payment-methods'	  : StudentPaymentMethods,
		'teacher-payment-methods'	  : TeacherPaymentMethods,
		'teacher-upcoming-lesson'   : TeacherUpcomingLesson,
		'student-upcoming-lesson'   : StudentUpcomingLesson,
		'teachers-notifications' 	  : TeachersNotifications,
		'teachers-library' 			 	  : TeachersLibrary,
		'teachers-calendar' 			  : TeachersCalendar,
		'teachers-purchase-history' : TeachersPurchaseHistory,
		'chat-panel'                : ChatPanel,
		'teacher-information'				: TeacherInformation,
		'workbook-shop'							: WorkbookShop,
		'student-feeds'							: StudentFeeds,
		'dashboard-panel'						: DashboardPanel,
		// 'settings-panel'				  : SettingsPanel,
		'navigation'								: Navigation,
		'upper-navigation'					: UpperNavigation,
		'teacher-information-main'	: TeacherInformationMain,
		'teaching-strategies'	      : TeachingStrategies,
		'strategy-filter'	          : StrategyFilter,
		'teacher-main-profile'	    : TeacherMainProfile,
		'teachers-workbooks'	      : TeachersWorkbooks,
		'workbook-materials'	      : WorkbookMaterials,
		'answer-materials'	        : AnswerMaterials,
		'teaching-strategies-card'	: TeachingStrategiesCard
	},
});



