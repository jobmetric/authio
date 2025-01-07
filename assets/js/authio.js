"use strict"

const authio = {
    token: {
        set: function(token){
            localStorage.setItem('token', JSON.stringify(token))
        },
        getStorage: function(){
            return localStorage.getItem('token');
        },
        get: function(){
            let token = this.getStorage()

            if (!token) {
                return null
            }

            return JSON.parse(token)?.access_token
        },
        getTime: function(){
            let token = this.getStorage()

            if (!token) {
                return 0
            }

            return JSON.parse(token)?.expires_in
        },
    },
}

$(document).ready(function () {

})
