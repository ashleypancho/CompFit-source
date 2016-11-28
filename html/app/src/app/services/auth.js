export default class {

    constructor($http) {
        this.$http = $http;
        this.loggedIn = false;
        this.email = "";
        this.password = "";

        this.observerCallbacks = [];
    }

    tryLogin(user) {
        // var data = {"email":email,"password":password};
        return this.$http.post("/api/auth",user).then(function(response){
            return response;
        });
    }

    logIn() {
        this.loggedIn = true;
        this.notifyObservers();
    }

    logOut() {
        this.loggedIn = false;
        this.notifyObservers();
    }


    //register an observer
   registerObserverCallback(callback){
      this.observerCallbacks.push(callback);
    }

    notifyObservers(){
       angular.forEach(this.observerCallbacks, function(callback){
         callback();
       });
     }

}
