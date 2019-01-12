import { userService } from '../_services';
import { router } from '../_helpers';
import { KJUR } from 'jsrsasign'; 

// var isValid = KJUR.jws.JWS.verify(response.data.access_token, "2CgU6QzbGWibNznWkgs2cCO1cXOdy54X", ["HS256"]);

const user = JSON.parse( localStorage.getItem('user') ) ;

const initialState = user 
? { status: {   loggedIn: true }, 
                user: KJUR.jws.JWS.parse( user ).payloadObj.user ,
                mensagem: null , 
                perfis: KJUR.jws.JWS.parse( user ).payloadObj.perfis } 
: { status: {}, user: null , mensagem: null , perfis:null};



export const authentication = {
    namespaced: true,
    state: initialState,
    
    actions: {


        login({ dispatch, commit }, { username, password }) {  
            return new Promise((resolve, reject) => {
                userService.login(username, password)
                .then( user => {
                    // window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + user ;
                    commit('loginSuccess', KJUR.jws.JWS.parse( user ).payloadObj  ); 
                    resolve()
                })
                .catch(error => { 
                    console.log(error);
                    commit('loginFailure', error);
                    reject(error); 
                }); 
            }) 
        },


        logout({ commit }) {
            userService.logout(); 
            commit('logout');
        },


    },



    mutations: {
        loginRequest(state, user) {
            state.status = { loggingIn: true };
            state.user = user; 
            state.mensagem = false;
            state.perfis = null;
        },
        loginSuccess(state, user ) {
            state.status = { loggedIn: true };
            state.user = user.user;
            state.mensagem = false;
            state.perfis =  user.perfis; 
        },
        loginFailure(state, error) {
            state.status = {loggedIn: false};
            state.user = null;
            state.mensagem = error;
            state.perfis = null;
        },
        logout(state) {
            state.status = {loggedIn: false };
            state.user = null;
            state.mensagem = false;
            state.perfis = null;
        }
    }
}