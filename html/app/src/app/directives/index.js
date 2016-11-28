import angular from 'angular';

import teams_sidebar from './teams_sidebar';
import create_challenge_modal from './create_challenge_modal';
import create_team_modal from './create_team_modal';
import challenges_sidebar from './challenges_sidebar';
import exercises_sidebar from './exercises_sidebar';
import log_exercise_modal from './log_exercise_modal';
import navbar from './navbar';
import player_progress_chart from './player_progress_chart';

export default angular
    .module( 'app.directives', [] )
    .directive( 'seedSidebar', ['Teams', 'Users', 'Challenges', teams_sidebar] )
    .directive( 'createChallengeModal', ['Teams','Users','Challenges','Exercises', '$timeout', '$state', create_challenge_modal] )
    .directive( 'createTeamModal', ['Teams','Users', '$timeout', '$state', create_team_modal] )
    .directive( 'challengesSidebar', ['Challenges','Users','$timeout', challenges_sidebar] )
    .directive( 'exercisesSidebar', ['Exercises', 'Users', '$timeout', exercises_sidebar] )
    .directive( 'logExerciseModal', ['Exercises','Users', '$timeout', '$state', log_exercise_modal] )
    .directive( 'seedNavbar', ['Authentication','Users','Teams','Challenges','Exercises','$state', navbar] )
    .directive( 'playerProgressChart', ['Challenges',player_progress_chart] )
    .name;
