/**
 * Created by jb on 27/09/15.
 */
$(".user-profile-friend-button--friends").mouseover(function() {
    $(".user-profile-friend-button--friends").val('Unfriend');
});
$(".user-profile-friend-button--friends").mouseout(function() {
    $(".user-profile-friend-button--friends").val("You're friends");
});

$(".user-profile-friend-button--invited").mouseover(function() {
    $(".user-profile-friend-button--invited").val('Uninvite');
});
$(".user-profile-friend-button--invited").mouseout(function() {
    $(".user-profile-friend-button--invited").val("Invited");
});

$(".user-profile-friend-button--invitationReceived").mouseover(function() {
    $(".user-profile-friend-button--invited").val('Confirm');
});
$(".user-profile-friend-button--invitationReceived").mouseout(function() {
    $(".user-profile-friend-button--invited").val("You've been invited!");
});
