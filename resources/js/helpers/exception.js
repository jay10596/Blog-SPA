import User from './user.js'

class Exception {
    handle(error) {
        this.isExpired(error.response.data.error)
    }

    isExpired(error) {
        if(error = 'Token is invalid') {
            User.logout()
        }
    }
}

export default Exception = new Exception()