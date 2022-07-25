import Token from './Token'
import AppStorage from './AppStorage'
class User{
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        if(Token.isValid(access_token)){
            AppStorage.store(res.data)
        }
    }
    hasToken(){
        const storeToken = localStorage.getItem('token');
        if(storeToken){
            return Token.isValid(storeToken)? true : false
        }
        false
    }
    loggedIn(){
        return this.hasToken()
    }
    name(){
        if(this.loggedIn()){
            return localStorage.getItem('name');
        }
    }
    userType(){
        if(this.loggedIn()){
            return localStorage.getItem('user_type');
        }
    }
    email(){
        if(this.loggedIn()){
            return localStorage.getItem('email');
        }
    }
    villageId(){
        if(this.loggedIn()){
            return localStorage.getItem('villageId');
        }
    }
    id(){
        if(this.loggedIn()){
            const payload = Token.payload(localStorage.getItem('token'));
            return payload.sub
        }
        return false
    }

}
export default User = new User();