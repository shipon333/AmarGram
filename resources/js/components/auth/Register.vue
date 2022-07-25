<template>
    <div>
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 nopadding col-md-offset-4">
                            <div class="bgoffsetbg">
                                <div class="loginbg">
                                    <div class="form-top">
                                        <div class="form-top-left logowidth">
                                            <img src="https://demo.smart-school.in/uploads/school_content/admin_logo/1.png" />
                                        </div>
                                    </div>
                                    <div class="form-bottom">
                                        <h3 class="font-white bolds">Login</h3>
                                        <form class="" method="post">
                                            <div class="form-group">
                                                <label for="form-username">Username</label>
                                                <input type="text" name="username" placeholder="Username" class="form-username form-control" id="form-username">
                                            </div>
                                            <div class="form-group">
                                                <label for="form-password">Password</label>
                                                <input type="text" name="password" placeholder="Password" class="form-username form-control" id="form-password">
                                            </div>
                                            <button type="submit" class="btn">Submit</button>
                                        </form>
                                        <router-link to="/" class="forgot">User Login</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register"
    }
</script>

<style scoped>
    .top-content {
        width: 100%;
        min-height: 95vh;
        padding-bottom: 50px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    .bgoffsetbg {
        background: #fff;
        box-shadow: 0px 0px 12px rgb(0 0 0 / 29%);
        overflow: hidden;
        border-radius: 4px;
    }
    .loginbg {
        background: #fff;
    }
    .form-top {
        background: transparent;
        /* box-shadow: 0px 7px 12px rgb(0 0 0 / 29%); */
        border-bottom: 1px solid #ddd;
    }
    .form-top {
        overflow: hidden;
        padding: 0 25px 15px 25px;
        background: #fff;
        -moz-border-radius: 4px 4px 0 0;
        -webkit-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
        text-align: left;
    }
    .form-top-left {
        /* text-align: center; */
        padding-top: 25px;
        padding-bottom: 8px;
    }
    .logowidth img {
        width: auto;
        height: 30px;
    }

    img {
        max-width: 100%;
    }
    .form-bottom {
        background: transparent;
    }
    .form-bottom {
        padding: 25px 25px 30px 25px;
        background: #fff;
        -moz-border-radius: 0 0 4px 4px;
        -webkit-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
        text-align: left;
    }
    .font-white {
        color: #444;
        font-size: 18px;
        margin-top: 0;
        font-weight: 400;
        margin-bottom: 15px;
    }
    .loginbg .text-danger {
        color: #a94442;
        font-size: 13px;
    }
    .form-bottom form button.btn {
        width: 100%;
    }

    button.btn {
        height: 40px;
        line-height: 40px;
    }
    a.forgot, button.btn {
        overflow: hidden;
        position: relative;
    }
    a.forgot {
        display: inline-block;
    }
    a.forgot {
        color: #444;
        text-decoration: none;
        font-size: 12px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-weight: 500;
        margin-top: 5px;
    }
    body{background:linear-gradient(to right,#676767 0,#dadada 100%);}
    .nopadding {border-right: 0px solid #ddd;}
</style>