import './style.styl';

export default function($scope, $stateParams, Teams, Users, Challenges, $state) {
    'ngInject';

    $scope.toggleModal = function(){
          $('#createteammodal').modal('show');
    };

    $scope.toggleChallengeModal = function(){
          $('#createchallengemodalinteams').modal('show');
    };

    $scope.state_id = $stateParams.id;
    $scope.current = true;
    $scope.team_id = -1;
    $scope.team_name = "";
    $scope.avatar = "/img/team_avatars/default-team.png";
    $scope.players = [];
    $scope.players_dropdown = false;
    $scope.team_selected = false;
    $scope.new_team = {};
    $scope.challenges = [];
    $scope.past_challenges = [];
    $scope.currentUser = Users.getCurrentUser();
    console.log("currentUser: " + $scope.currentUser);


    $scope.getDayDifference = function(date1_obj,date2_obj) {
        var date2 = new Date(date2_obj);
        var date1 = new Date(date1_obj);
        var timeDiff = date2.getTime() - date1.getTime();
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        return diffDays;
    };

    $scope.getDaysLeft = function(challenge) {
        return getDayDifference(new Date(),challenge.end_date)+1;
    };

    $scope.leaveAlert = function(player_id, player_name) {
        console.log("running leaveAlert("+player_id+")");
        var disband, removePlayer, leaveTeam;
        if($scope.isCaptain) {
            if(player_id == $scope.currentUser) {
                disband = confirm("You are currently team captain. If you leave this group, you will disband the team. Are you sure you want to disband the team?\n\n Disbanding teams is not yet available.");
            } else {
                removePlayer = confirm("Are you sure you want to remove " + player_name + " from the team?\n\n Removing members is not yet available.");
            }
        } else {
            leaveTeam = confirm("Are you sure you want to leave " + $scope.team_name + "?\n\n Leaving teams is not yet available.");
        }
    };

    $scope.showEmail = function(email) {
        alert(email);
    };


    if ($stateParams.id == "") {
        Teams.getTeamsForUser(Users.getCurrentUser()).then(function(response){
            var teams = response.data;
            if (teams !== undefined) {
                if (teams[0] !== undefined) {
                    $state.go('app.team', {'id': teams[0].team_id});
                }
            }
        });
    }
    else {
        $scope.team_id = $stateParams.id;
        $scope.team_selected = true;
        Teams.getTeamById($scope.team_id).then(function(response){
            $scope.thisTeam = response.data;
            console.log(response.data);
            $scope.avatar = response.data.avatar;
            $scope.players = response.data.players;
            $scope.team_name = response.data.team_name;
            $scope.captain_id = response.data.captain_id;
            $scope.isCaptain = Users.getCurrentUser() == response.data.captain_id;
            console.log($scope.isCaptain);
        });
        Challenges.getChallengesForTeam($scope.team_id).then(function(response){
            $scope.challenges = response.data;
            console.log("challenges: ",response);
        });
        Challenges.getPastChallengesForTeam($scope.team_id).then(function(response){
            if (response.data.message == "Not found") {
                console.log("past challenges for team not working yet")
            }
            else {
                $scope.past_challenges = response.data;
                console.log("past_challenges: ",response);
            }

        });

    }

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

    $scope.getUserProgress = function(challenge) {
        if (challenge.task_type == 'Individual') {
            return Math.round(100 * challenge.user_progress/challenge.repetitions);
        }
        else {
            return (100 * challenge.user_progress/challenge.repetitions/challenge.user_team.num_members).toFixed(1);
        }
    };

    $scope.getProgressLongFraction = function(challenge, team) {
        if (team == 'my_team')
        {
            if (challenge.task_type == 'Individual') {
                return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.user_team.players.length);
            }
            else {
                return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String((challenge.repetitions));
            }
        }
        else
        {
            if (challenge.task_type == 'Individual') {
                return String(Math.round(10*parseFloat(challenge.oppo_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.oppo_team.players.length);
            }
            else {
                return String(Math.round(10*parseFloat(challenge.oppo_team.team_progress))/10)+" / "+String(challenge.repetitions);
            }
        }
    };
}
