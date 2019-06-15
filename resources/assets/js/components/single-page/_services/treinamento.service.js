import { authHeader  } from '../_helpers'; 


export const treinamentoService = { 
	getUrl,
	getTodasPerguntas, 
	responder,
	getHistorico,	
};


const url = '/api/v1/treinamento' ;



function getUrl(  ) { 
	return  url; 
}



function getTodasPerguntas( data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url + '/todas'  , data  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 

function responder( data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url   , data  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}

 
// function criarComentario( data ) { 
// 	return  new Promise((resolve, reject) => {
// 		axios.post( url + '/criar/comentario'   , data  , {headers: authHeader() }  )
// 		.then(response => {    
// 			resolve( response.data);  
// 		})
// 		.catch(error => {  
// 			reject(error.response);
// 		}) 
// 	}); 
// }
 
 
function getHistorico( data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url + '/historico'   , data  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
 

 
// function getRank(  ) { 
// 	return  new Promise((resolve, reject) => {
// 		axios.get( url + '/meu/rank'     , {headers: authHeader() }  )
// 		.then(response => {    
// 			resolve( response.data);  
// 		})
// 		.catch(error => {  
// 			reject(error.response);
// 		}) 
// 	}); 
// }
  
 
// function buscarPerfis( id ) { 
// 	return  new Promise((resolve, reject) => {
// 		axios.get( url + '/' + id + "/perfil/adicionar" , {headers: authHeader() }  )
// 		.then(response => {    
// 			resolve( response.data);  
// 		})
// 		.catch(error => {  
// 			reject(error.response);
// 		}) 
// 	}); 
// }
 

 