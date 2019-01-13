import { authHeader } from '../../_helpers'; 

 
export const comentarioService = { 
	getUrl, 
	getComentario,
};


const url = '/api/v1/comentario' ;



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

// function getAll(  ) { 
// 	return  new Promise((resolve, reject) => {
// 		axios.get( url + '/all'  , {headers: authHeader() }  )
// 		.then(response => {    
// 			resolve( response.data);  
// 		})
// 		.catch(error => {  
// 			reject(error.response);
// 		}) 
// 	}); 
// }


 
 