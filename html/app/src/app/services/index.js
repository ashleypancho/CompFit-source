import angular from 'angular';

import auth from './auth';
import teams from './teams';
import challenges from './challenges';
import exercises from './exercises';
import users from './users';

export default angular
    .module( 'app.services', [] )
    .service( 'Authentication', ['$http',auth] )
    .service( 'Teams', ['$http',teams] )
    .service( 'Challenges', ['$http',challenges] )
    .service( 'Exercises', ['$http',exercises] )
    .service( 'Users', ['$http',users] )
    .name;
