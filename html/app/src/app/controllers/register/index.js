import './style.styl';

export default function($scope, $stateParams, Users, $state,Authentication) {
    'ngInject';
    $scope.team_id = $stateParams.id;
    $scope.avatar = "/img/user_avatars/default-avatar.png";

    $scope.submit = function(newUser) {
        console.log(newUser);
        Users.createUser(newUser).then(function(response) {
            console.log(response);
            if (response.data.error != undefined) {
                console.log("ERROR! in posting register", response.data.error);
            }
            else {
                Users.setCurrentUser(response.data.user_id);
                Users.username = newUser.username;
                console.log("user id:",Users.getCurrentUser());
                Authentication.logIn();

                $state.go( 'app.team' );
            }
        });
    }
}
