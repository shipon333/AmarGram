require('./bootstrap');

import Alpine from 'alpinejs';
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
// all routes import here
import {routes} from './routes';
// import user token class
import User from './Helpers/User';
window.User = User

//Notification
import  Notification from './Helpers/Notification';
window.Notification = Notification
// sweetalert start
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;
//toastr notification
import toastr from "toastr";
window.toastr = toastr;
const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
});
const app = new Vue({
   el: '#app',
    router,
    data(){
        return{
            loggedInUserType: User.userType()
        }
    },
    updated(){
       this.loggedInUserType = User.userType();
    }
});