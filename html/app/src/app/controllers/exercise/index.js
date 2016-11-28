import './style.styl';

export default function($scope, $stateParams, Exercises, Users, Challenges, Teams, $state) {
    'ngInject';

    $scope.toggleModal = function(){
        console.log($scope.new_log);
          $('#logexercisemodal').modal('show');
    };

    $scope.exercise_id = -1;
    $scope.exercise_selected = false;

    $scope.exercises = [];

    $scope.exercise = {};


    $scope.new_log = {};

    if ($stateParams.id == "") {
        Exercises.getExercisesForUser(Users.getCurrentUser()).then(function(response){
            var exercises = response.data;
            if (exercises !== undefined) {
                if (exercises[0] !== undefined) {

                    $state.go('app.exercise', {'id': exercises[0].exercise_id});
                }
            }
        });
    }
    else  {
        $scope.exercise_id = $stateParams.id;
        $scope.exercise_selected = true;

        Exercises.getExerciseById($scope.exercise_id).then(function(response) {
            console.log("exercise",response);
            $scope.exercise = response.data;
        });

        Challenges.getChallengesForExercise($scope.exercise_id).then(function(response){
            console.log("challenges:",response);
            $scope.challenges = response.data;
        });
    }

    $scope.getTeamProgress = function(challenge) {
        if (challenge.task_type == 'Individual') {
            return (100 * challenge.user_team.team_progress/challenge.repetitions/challenge.user_team.num_members);
        }
        else {
            return (100 * challenge.user_team.team_progress/challenge.repetitions);
        }
    };
    $scope.getUserProgress = function(challenge) {
        if (challenge.task_type == 'Individual') {
            return (100 * challenge.user_progress/challenge.repetitions).toFixed(0);
        }
        else {
            return (100 * challenge.user_progress/challenge.repetitions*challenge.user_team.num_members).toFixed(0);
        }
    };

    $scope.getUserAddition = function(challenge) {
        if (challenge.task_type == 'Individual') {
            return (100 * challenge.exercise_progress/challenge.repetitions/challenge.user_team.num_members);
        }
        else {
            return (100 * challenge.exercise_progress/challenge.repetitions);
        }
    };

    $scope.getAdjustedTeamProgress = function(challenge) {
        return Math.round($scope.getTeamProgress(challenge) - $scope.getUserAddition(challenge));
    };


    $scope.getProgressFraction = function(challenge, team) {
        if (team == 'my_team')
        {
            if (challenge.task_type == 'Individual') {
                return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.user_team.num_members);
            }
            else {
                return String(Math.round(10*parseFloat(challenge.user_team.team_progress))/10)+" / "+String((challenge.repetitions));
            }
        }
        else
        {
            if (challenge.task_type == 'Individual') {
                return String(Math.round(10*parseFloat(challenge.oppo_team.team_progress))/10)+" / "+String(challenge.repetitions*challenge.oppo_team.num_members);
            }
            else {
                return String(Math.round(10*parseFloat(opponent_team.team_progress))/10)+" / "+String(challenge.repetitions);
            }
        }
    };

}
