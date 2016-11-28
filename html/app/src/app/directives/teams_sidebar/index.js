import './style.styl';
import template from 'directives/teams_sidebar/template.html';

export default function(Teams, Users,Challenges) {

    return {
        restrict: 'E',
        replace: true,
        link: function ($scope, $element, $attrs) {
            $scope.teams = Teams.getTeams();
            $scope.getDayDifference = function(date1_obj,date2_obj) {
                var date2 = new Date(date2_obj);
                var date1 = new Date(date1_obj);
                var timeDiff = date2.getTime() - date1.getTime();
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                return diffDays;
            };

            $scope.getDaysLeft = function(challenge) {
                if (challenge) {
                    return $scope.getDayDifference(new Date(),challenge.end_date)+1;
                }
            };

            if (!$scope.teams || Teams.user_for_teams != Users.getCurrentUser()) {
                Teams.getTeamsForUser(Users.getCurrentUser()).then( function(response) {
                    // console.log(response.data);
                    $scope.teams = response.data;
                });
            }
            else {
                // for(var i=0; i<$scope.teams.length; i++) {
                //     var spot = i;
                //     Challenges.getChallengesForTeam($scope.teams[i].team_id).then(function(response){
                //         console.log(spot);
                //         $scope.teams[spot].challenges = response.data;
                //         console.log(spot,$scope.teams);
                //     });
                // }

            }


        },
        templateUrl: template
    };
}
