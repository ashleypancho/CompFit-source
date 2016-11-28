export default class {

    constructor($http) {
        this.$http = $http;
        var self = this;

        self.teams = [];
        self.user_for_teams = 1;
    }

    createTeam(team_name,captain_id,players,avatar="/img/team_avatars/default-team.png") {
        var data = {"team_name":team_name,"captain_id":captain_id,"players":players,"avatar":avatar};
        console.log(data);
        return this.$http.post("/api/team",data).then(function (response) {
            return response;
        });
    }

    getTeamById(team_id) {
        return this.$http({
              method: 'GET',
              url: '/api/team/'+team_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getTeamsByCaptianId(captain_id) {
        return this.$http({
              method: 'GET',
              url: '/api/teams/captain_id/'+captain_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getTeamsForUser(user_id) {
        return this.$http({
              method: 'GET',
              url: '/api/teams/'+user_id
            }).then(function successCallback(response) {
                var teams = response.data;

                teams.sort(function(a,b){
                    if (!a.challenges[0]) {
                        return 1;
                    }
                    if(!b.challenges[0]) {
                        return -1;
                    }
                    return new Date(a.challenges[0].end_date) - new Date(b.challenges[0].end_date);
                });

                self.teams = teams;
                self.user_for_teams = user_id;

                console.log(response);
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getAllTeams() {
        return this.$http({
              method: 'GET',
              url: '/api/teams'
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getAllOpponentTeams(captain_id) {
        return this.$http({
              method: 'GET',
              url: '/api/teams/opponents/'+captain_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getTeams() {
        return self.teams;
    }

}
