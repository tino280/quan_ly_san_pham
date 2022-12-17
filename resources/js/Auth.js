import axios from 'axios';

class Auth {

    constructor () {
        this.token = window.localStorage.getItem('token');
        let userData = window.localStorage.getItem('user');
        this.user = userData ? JSON.parse(userData) : null;

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }
    }

    login (token, user) {
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        this.user = user;
        this.token = token;
    }

    updateToken () {
        this.token = localStorage.getItem('token');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        console.log(axios.defaults.headers.common);
    }

    logout () {
        // window.localStorage.clear();
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.token = null;
        this.user = null;
    }    
}

export default new Auth();