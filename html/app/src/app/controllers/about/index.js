import './style.styl';

export default function($scope, $stateParams, Teams) {
    'ngInject';
    $scope.team_id = $stateParams.id;
    $scope.avatar = "/img/team_avatars/default-avatar.png";


    Teams.getTeamById($scope.team_id).then(function(response){
        $scope.thisTeam = response.data;
        console.log(response.data);
        $scope.avatar = response.data.avatar;
    });


}
