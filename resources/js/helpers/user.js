import Token from './token'
import Storage from './storage'

class User {
    responseAfterLogin(res) {
        const token = res.data.access_token
        const username = res.data.user

        if(Token.isValid(token))
        {
            Storage.store(token, username)
        }
    }

    hasToken() {
        const storedToken = Storage.getToken()
        
        if(storedToken){
            return Token.isValid(storedToken) ? true : false
        }

        return false
    }

    loggedIn() {
        return this.hasToken()
    }

    logout(){
        Storage.clear()
    }

    name() {
        if(this.loggedIn()){
            return Storage.getUsername()
        }
    }

    id() { //id is the sub: part of the payload
        if(this.loggedIn()){
            const payload = Token.getPayload(Storage.getToken())
            return payload.sub
        }
    }

    own(id) {
        return this.id() == id
    }
}

export default User = new User();
