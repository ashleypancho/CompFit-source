import applicationTemplate from 'controllers/application/template.html';

import authenticationTemplate from 'controllers/authentication/template.html';
import homeTemplate from 'controllers/home/template.html';
import loginTemplate from 'controllers/login/template.html';
import myProfileTemplate from 'controllers/myProfile/template.html';
import teamTemplate from 'controllers/team/template.html';
import challengeTemplate from 'controllers/challenge/template.html';
import exerciseTemplate from 'controllers/exercise/template.html';
import aboutTemplate from 'controllers/about/template.html';
import registerTemplate from 'controllers/register/template.html';

export default function ( $stateProvider, $urlRouterProvider, $locationProvider ) {
    'ngInject';

    $locationProvider.html5Mode( {
        enabled: true,
        requireBase: false
    } );

    $urlRouterProvider.otherwise( '/' );



    $stateProvider
        .state( 'app', {
            url: '',
            abstract: true,
            templateUrl: applicationTemplate,
            controller: 'ApplicationController'
        } )
        .state( 'app.about', {
            url: '/about/',
            templateUrl: aboutTemplate,
            controller: 'AboutController'
        } )
        .state( 'app.register', {
            url: '/register/',
            templateUrl: registerTemplate,
            controller: 'RegisterController'
        } )
        .state( 'app.home', {
            url: '/',
            templateUrl: homeTemplate,
            controller: 'HomeController'
        } )
        .state( 'app.team', {
            url: '/team/:id',
            templateUrl: teamTemplate,
            controller: 'TeamController'
        } )
        .state( 'app.challenge', {
            url: '/challenge/:id',
            templateUrl: challengeTemplate,
            controller: 'ChallengeController'
        } )
        .state( 'app.exercise', {
            url: '/exercise/:id',
            templateUrl: exerciseTemplate,
            controller: 'ExerciseController'
        } )
        .state( 'app.login', {
            url: '/login',
            templateUrl: loginTemplate,
            controller: 'LoginController'
        } )
        .state( 'app.my', {
            url: '/my',
            templateUrl: authenticationTemplate,
            controller: 'AuthenticationController'
        } )
        .state( 'app.my.profile', {
            url: '/profile',
            templateUrl: myProfileTemplate,
            controller: 'MyProfileController'
        } );
}
