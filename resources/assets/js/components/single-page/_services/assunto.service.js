import { authHeader } from '../_helpers'; 

 
export const assuntoService = {
	getAssunto ,
	getPerguntasPorAssunto
};


const url = '/api/v1/assunto' ;



function getAssunto( id ) { 
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
 
function getPerguntasPorAssunto( id ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/' + id + '/perguntas'  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 