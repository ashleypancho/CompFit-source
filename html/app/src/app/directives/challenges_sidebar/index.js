import './style.styl';
import template from 'directives/challenges_sidebar/template.html';

export default function(Challenges, Users, $timeout) {

    return {
        restrict: 'E',
        replace: true,
        link: function ($scope, $element, $attrs) {
              $scope.challenges = Challenges.getChallenges();
              $scope.past_challenges = Challenges.getPastChallenges();
              $scope.showCurrent = Challenges.showCurrentChallenges;

              $scope.getDayDifference = function(date1_obj,date2_obj) {
                  var date2 = new Date(date2_obj);
                  var date1 = new Date(date1_obj);
                  var timeDiff = date2.getTime() - date1.getTime();
                  var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                  return diffDays;
              };

              $scope.getDaysLeft = function(challenge) {
                  return $scope.getDayDifference(new Date(),challenge.end_date)+1;
              };

              $scope.getTeamProgress = function(challenge) {
                  if (challenge.task_type == 'Individual') {
                      return Math.round(100 * challenge.user_team.team_progress/challenge.repetitions/challenge.user_team.players.length);
                  }
                  else {
                      return Math.round(100 * challenge.user_team.team_progress/challenge.repetitions);
                  }

              };

              $scope.getOppoTeamProgress = function(challenge) {
                  if (challenge.task_type == 'Individual') {
                      return Math.round(100 * challenge.oppo_team.team_progress/challenge.repetitions/challenge.oppo_team.players.length);
                  }
                  else {
                      return Math.round(100 * challenge.oppo_team.team_progress/challenge.repetitions);
                  }
              };

              $scope.scrollTo = Challenges.currentSidebarScrollPosition;
              if ($scope.scrollTo != null) {
                  $timeout(function(){
                    //   $('#challengelist').animate({
                    //       scrollTop: $scope.scrollTo
                    //   });

                        if ($scope.showCurrent) {
                            $('#challengelist').scrollTop($scope.scrollTo);
                        }
                        else {
                            $('#pastchallengelist').scrollTop($scope.scrollTo);
                        }

                    }, 0);
              }

              $('#challengelist').css('max-height', (window.innerHeight-146)+'px');
              $('#pastchallengelist').css('max-height', (window.innerHeight-146)+'px');

              $(window).resize(function() {
                $('#challengelist').css('max-height', (window.innerHeight-146)+'px');
                $('#pastchallengelist').css('max-height', (window.innerHeight-146)+'px');
              });

              $scope.saveScrollPosition = function() {
                  if ($scope.showCurrent) {
                      Challenges.currentSidebarScrollPosition = $('#challengelist').scrollTop();
                  }
                  else {
                      Challenges.currentSidebarScrollPosition = $('#pastchallengelist').scrollTop();
                  }
              };

              $scope.saveStateInfo = function() {
                  $scope.saveScrollPosition();
                  Challenges.showCurrentChallenges = $scope.showCurrent;
              };

              $scope.showCurrentChallenges = function() {
                  $scope.showCurrent=true;
                //   if ($scope.challenges !== undefined) {
                //       if ($scope.challenges[0] !== undefined) {
                //           $state.go('app.challenge', {'id': $scope.challenges[0].challenge_id});
                //       }
                //   }
              };

              $scope.showPastChallenges = function() {
                  $scope.showCurrent=false;
              };



              if (!$scope.challenges) {
                  Challenges.getChallengesForUser(Users.getCurrentUser()).then( function(response) {
                      console.log(response.data);
                      $scope.challenges = response.data;
                  });
              }

              if (!$scope.past_challenges) {
                  Challenges.getPastChallengesForUser(Users.getCurrentUser()).then( function(response) {
                      console.log(response.data);
                      $scope.past_challenges = response.data;
                  });
              }
        },
        templateUrl: template
    };
}
