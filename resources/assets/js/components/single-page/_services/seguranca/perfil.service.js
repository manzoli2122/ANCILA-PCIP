import { authHeader } from '../../_helpers'; 

 
export const perfilService = {
	getPerfil,
	getUrl, 
	buscarPermissoes,
};


const url = '/api/v2/perfil' ;



function getUrl(  ) { 
	return  url; 
}



function getPerfil( id ) { 
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
  

function buscarPermissoes( id ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/' + id + '/permissao/adicionar'  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
  
 
 