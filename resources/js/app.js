import './bootstrap';

import { index, showUser,editUser,store,deleteUser } from './functions';

import Alpine from 'alpinejs';



window.index = index;
window.store = store;
window.showUser = showUser;
window.editUser = editUser;
window.deleteUser = deleteUser;


window.Alpine = Alpine;

Alpine.start();
