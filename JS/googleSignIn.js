function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    window.location = "http://casper.te4.nu/BikePool/PHP/authID.php?token=" + id_token;
};
