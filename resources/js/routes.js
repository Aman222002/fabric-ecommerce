{
  path: 'profile',
  name: 'profile',
  component: Vue.component( 'Profile', require( './pages/Profile.vue' ) ),
  beforeEnter: requireAuth
}