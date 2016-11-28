export default class {

    constructor($http) {
        this.$http = $http;
        this.user_id = 1;
        this.username = "billybob";
        var self = this;
        // self.user_id = 1;
    }

    getCurrentUser() {
        return this.user_id;
    }

    setCurrentUser(new_id) {
        this.user_id = new_id;
    }

    getAllUsers() {
        return this.$http({
              method: 'GET',
              url: '/api/user'
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    createUser(newUser) {
        var data = newUser;
        return this.$http.post("/api/user",data).then(function (response) {
            return response;
        });
    }

    getUserById(user_id) {
        return this.$http({
              method: 'GET',
              url: '/api/user/'+user_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getUserByUsername(username) {
        return this.$http({
              method: 'GET',
              url: '/api/username/'+username
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getUsersForTeam(team_id) {
        return this.$http({
              method: 'GET',
              url: '/api/users/'+team_id
            }).then(function successCallback(response) {
                // self.teams = response.data;
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

}
