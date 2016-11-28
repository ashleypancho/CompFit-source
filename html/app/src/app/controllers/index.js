import angular from 'angular';

import ApplicationController from './application';

import AuthenticationController from './authentication';
import HomeController from './home';
import LoginController from './login';
import MyProfileController from './myProfile';
import TeamController from './team';
import ChallengeController from './challenge';
import ExerciseController from './exercise';
import AboutController from './about';
import RegisterController from './register';

export default angular
    .module( 'app.controllers', [] )
    .controller( 'ApplicationController', ApplicationController )
    .controller( 'AuthenticationController', AuthenticationController )
    .controller( 'HomeController', HomeController )
    .controller( 'LoginController', LoginController )
    .controller( 'MyProfileController', MyProfileController )
    .controller( 'TeamController', TeamController )
    .controller( 'ChallengeController', ChallengeController )
    .controller( 'ExerciseController', ExerciseController )
    .controller( 'AboutController', AboutController )
    .controller( 'RegisterController', RegisterController )
    .filter('capitalize', function() {
        return function(input) {
          return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
        }
    })
    .name;
