window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

var notifications = [];

const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\OrderProduct'
};
$(document).ready(function() {
    // check if there's a logged in user
    if(Laravel.userId) {
        $.get('/notifications', function (data) {
            addNotifications(data, "#notifications");
        });
    }
});

function addNotifications(newNotifications, target) {
	console.log();
}