<?php

namespace App\Routes;

final class RouteName
{
    private function __construct()
    {}

    public const APP_HOME = 'app_home';
    public const APP_NAV = 'app_nav';
    public const APP_REGISTER = 'app_register';
    public const APP_LOGIN = 'app_login';
    public const APP_LOGOUT = 'app_logout';
    public const APP_SWITCH_ROLE = 'app_switch_role';
    public const APP_PREFERENCE_CHANGE_THEME = 'app_preference_change_theme';

    //-------------------------------------------
    public const APP_VISITOR = 'app_visitor';
    //-------------------------------------------
    public const USER_HOME = 'user_home';
    public const USER_PERFIL = 'user_perfil';
    public const USER_PERFIL_PASSWORD = 'user_perfil_password';
    public const USER_PREFERENCE = 'user_preference';
    public const USER_SCHEDULE = 'user_schedule';
    public const USER_WORKOUT = 'user_workout';

    // ----------------------------------------
    public const MANAGER_HOME = 'manager_home';
    public const MANAGER_EXERCISE = 'manager_exercise';
    public const MANAGER_EXERCISE_CREATE = 'manager_exercise_create';
    public const MANAGER_EXERCISE_EDIT = 'manager_exercise_edit';
    public const MANAGER_EXERCISE_DELETE = 'manager_exercise_delete';
    public const MANAGER_WORKOUT = 'manager_workout';
    public const MANAGER_WORKOUT_CREATE = 'manager_workout_create';
    public const MANAGER_WORKOUT_EDIT = 'manager_workout_edit';

    //-----------------------------------------

    public const ADMIN = 'admin';
}
