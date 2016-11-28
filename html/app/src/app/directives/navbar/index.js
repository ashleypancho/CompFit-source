import './style.styl';
import template from 'directives/navbar/template.html';

export default function(Authentication, Users,Teams,Challenges,Exercises, $state) {
    return {
        restrict: 'E',
        link: function ($scope, $element, $attrs) {
            $scope.loggedIn = Authentication.loggedIn;
            $scope.loggedInTest = true;

            $scope.first_team = '';
            $scope.first_exercise = '';
            $scope.first_challenge = '';

            $scope.state = $state;

            $scope.gotoFirstTeam = function() {
                console.log($scope.first_team, typeof($scope.first_team));
                $state.go('app.team', {'id': $scope.first_team});
            };
            $scope.gotoFirstChallenge = function() {
                console.log($scope.first_challenge, typeof($scope.first_challenge));
                $state.go('app.challenge', {'id': $scope.first_challenge});
            };
            $scope.gotoFirstExercise = function() {
                console.log($scope.first_exercise, typeof($scope.first_exercise));
                $state.go('app.exercise', {'id': $scope.first_exercise});
            };

            var updateLoggedIn = function(){
                $scope.loggedIn = Authentication.loggedIn;
                $scope.first_team = '';
                $scope.first_exercise = '';
                $scope.first_challenge = '';

                $scope.user_id = Users.getCurrentUser();

                Teams.getTeamsForUser($scope.user_id).then(function(response){
                    var teams = response.data;
                    if (teams !== undefined) {
                        if (teams[0] !== undefined) {
                            $scope.first_team = teams[0].team_id;
                        }
                    }
                });

                Challenges.getChallengesForUser($scope.user_id).then(function(response){
                    var challenges = response.data;
                    if (challenges !== undefined) {
                        if (challenges[0] !== undefined) {
                            $scope.first_challenge = challenges[0].challenge_id;
                        }
                    }
                });

                Exercises.getExercisesForUser($scope.user_id).then(function(response){
                    var exercises = response.data;
                    if (exercises !== undefined) {
                        if (exercises[0] !== undefined) {
                            $scope.first_exercise = exercises[0].exercise_id;
                        }
                    }
                });
              };

              updateLoggedIn();

            Authentication.registerObserverCallback(updateLoggedIn);
        },
        templateUrl: template
    };
}
