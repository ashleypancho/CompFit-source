import './style.styl';
// import ngImg from '/img/user_avatars/default-avatar.png';

export default function( $scope, $state, Authentication, Users ) {
    'ngInject';

    $scope.ngImg = '/img/user_avatars/default-avatar.png';

    if (!Authentication.loggedIn) {
        $state.go( 'app.login' );
    }

    Users.getUserById(Users.getCurrentUser()).then(function(response){
        $scope.user = response.data;
        console.log($scope.user);
    });



    $scope.logout = function() {
        Authentication.logOut();
        $state.go( 'app.home' );
    };

}
