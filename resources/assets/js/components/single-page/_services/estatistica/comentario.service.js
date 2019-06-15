import { authHeader } from '../../_helpers'; 

 
export const comentarioService = { 
	getUrl, 
	getComentario,
	criarComentario,
};


const url = '/api/v2/comentario' ;



function getUrl(  ) { 
	return  url; 
}



function getComentario( id ) { 
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


function criarComentario( data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url  , data  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 
 