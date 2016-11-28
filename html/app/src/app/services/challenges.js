export default class {

    constructor($http) {
        this.$http = $http;
        this.currentSidebarScrollPosition = null;
        this.showCurrentChallenges = true;
        this.observerCallbacks = [];

        this.observeToReflow = [];

        this.maxYaxis = 0;
        var self = this;

        self.challenges = [];
        self.past_challenges = [];
    }

    resetChartAxis() {
        this.maxYaxis = 0;
    }

    getChartHeight() {
        return this.maxYaxis;
    }

    setChartHeight(num) {
        if (num > this.maxYaxis) {
            this.maxYaxis = num;
            this.notifyObservers();
        }
        // return this.maxYaxis;
    }

    createChallenge(challenge) {
        return this.$http.post("/api/challenge",challenge).then(function(response){
            return response;
        });
    }

    getChallengeById(challenge_id) {
        return this.$http({
              method: 'GET',
              url: '/api/challenge/'+challenge_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getChallengeProgress(challenge_id) {
        return this.$http({
              method: 'GET',
              url: '/api/challenge_progress/'+challenge_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getChallengesForUser(user_id) {
        return this.$http({
              method: 'GET',
              url: '/api/challenges/user_id/'+user_id
            }).then(function successCallback(response) {
                var challenges = response.data;

                challenges.sort(function(a,b){
                  return new Date(a.end_date) - new Date(b.end_date);
                });

                for (var i = 0; i < challenges.length; i++) {
                    challenges[i]
                }
                var getProgressLongFraction = function(challenge, team) {
                    if (team == 'my_team')
                    {
                        if (challenge.task_type == 'Individual') {
                            return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.user_team.players.length);
                        }
                        else if(challenge.task_type == 'Group') {
                            return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String((challenge.repetitions));
                        }
                    }
                    else
                    {
                        if (challenge.task_type == 'Individual') {
                            return String(Math.round(10*parseFloat(challenge.oppo_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.oppo_team.players.length);
                        }
                        else if(challenge.task_type == 'Group') {
                            return String(Math.round(10*parseFloat(challenge.oppo_team.team_progress))/10)+" / "+String(challenge.repetitions);
                        }
                    }
                }

                for (var i = 0; i < challenges.length; i++) {
                    challenges[i].user_team.fraction_team_progress = getProgressLongFraction(challenges[i],'my_team');
                    challenges[i].oppo_team.fraction_team_progress = getProgressLongFraction(challenges[i],'opponent_team');
                }
                console.log("All the challenges",challenges)

                self.challenges = challenges;
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getPastChallengesForUser(user_id) {
        return this.$http({
              method: 'GET',
              url: '/api/past_challenges/user_id/'+user_id
            }).then(function successCallback(response) {
                var past_challenges = response.data;
                var getProgressLongFraction = function(past_challenge, team) {
                    if (team == 'my_team')
                    {
                        if (past_challenge.task_type == 'Individual') {
                            return String(Math.round(10*parseFloat(past_challenge.user_team.team_progress))/10)+" / "+String(past_challenge.repetitions*past_challenge.user_team.players.length);
                        }
                        else if(past_challenge.task_type == 'Group') {
                            return String(Math.round(10*parseFloat(past_challenge.user_team.team_progress))/10)+" / "+String((past_challenge.repetitions));
                        }
                    }
                    else
                    {
                        if (past_challenge.task_type == 'Individual') {
                            return String(Math.round(10*parseFloat(past_challenge.oppo_team.team_progress))/10)+" / "+String(past_challenge.repetitions*past_challenge.oppo_team.players.length);
                        }
                        else if(past_challenge.task_type == 'Group') {
                            return String(Math.round(10*parseFloat(past_challenge.oppo_team.team_progress))/10)+" / "+String(past_challenge.repetitions);
                        }
                    }
                }

                for (var i = 0; i < past_challenges.length; i++) {
                    past_challenges[i].user_team.fraction_team_progress = getProgressLongFraction(past_challenges[i],'my_team');
                    past_challenges[i].oppo_team.fraction_team_progress = getProgressLongFraction(past_challenges[i],'opponent_team');
                }
                console.log("All the challenges",past_challenges)

                self.past_challenges = past_challenges;
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }
    getPastChallengesForTeam(team_id) {
        return this.$http({
              method: 'GET',
              url: '/api/past_team_challenges/'+team_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getChallengesForExercise(exercise_id) {
        return this.$http({
              method: 'GET',
              url: '/api/challenges/exercise_id/'+exercise_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getChallengesForTeam(team_id) {
        return this.$http({
              method: 'GET',
              url: '/api/team_challenges/'+team_id
            }).then(function successCallback(response) {
                return response;
              }, function errorCallback(response) {
                return response;
            });
    }

    getChallenges() {
        return self.challenges;
    }

    getPastChallenges() {
        return self.past_challenges;
    }

    //register an observer
   registerObserverCallback(callback){

      this.observerCallbacks.push(callback);
      if (this.observerCallbacks.length > 2) {
          this.observerCallbacks = this.observerCallbacks.slice(-2);
      }
    }

    registerReflowCallback(callback){

       this.observeToReflow.push(callback);
       if (this.observeToReflow.length > 2) {
           this.observeToReflow = this.observeToReflow.slice(-2);
       }
     }

     reflowCharts(){
        angular.forEach(this.observeToReflow, function(callback){
          callback();
        });
     }

    notifyObservers(){
       angular.forEach(this.observerCallbacks, function(callback){
         callback();
       });
    }



}
