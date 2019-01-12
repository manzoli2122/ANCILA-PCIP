import { authHeader } from '../_helpers'; 

 
export const respostaService = {
	editarResposta,
	criarResposta,
	
};


const url = '/api/v1/resposta' ;



function editarResposta( id , data ) { 
	return  new Promise((resolve, reject) => {
		axios.patch( url + '/' + id  , data , { headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}


function criarResposta(   data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url  , data , { headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
  
 