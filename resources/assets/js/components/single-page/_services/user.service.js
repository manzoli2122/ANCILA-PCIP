import { authHeader } from '../_helpers'; 



export const userService = {
	login,
	logout,
	getUrl,
	getUsuario,
	buscarPerfis,
};


const url = '/api/v2/usuario' ;



function getUrl(  ) { 
	return  url; 
}



function getUsuario( id ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/' + id  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 
 
function buscarPerfis( id ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/' + id + "/perfil/adicionar" , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 



function login(id, password) {

	let data = {};  
	data['id'] = id ;  
	data['password'] = password ;  

	return  new Promise((resolve, reject) => {
		axios.post('/api/auth/login' , data )
		.then(response => {   
			localStorage.setItem('user', JSON.stringify(response.data.access_token));
			resolve( response.data.access_token);  
		})
		.catch(error => { 
			if ( error.response.status === 401) {
				logout();				
			}
			reject(error.response.data.error);
		})

	});


}

function logout() { 
	localStorage.removeItem('user');
	localStorage.clear( ); 
}