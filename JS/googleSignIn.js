function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    window.location = "http://localhost/BikePool/PHP/authID.php?token=" + id_token;
};
