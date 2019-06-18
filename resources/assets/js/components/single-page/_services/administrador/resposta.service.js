import { authHeader } from '../../_helpers'; 

 
export const respostaService = {
	editarResposta,
	criarResposta,
	getUrl,
	getResposta,
};


const url = '/api/v2/resposta' ;



function getUrl(  ) { 
	return  url; 
}



function getResposta( id ) { 
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
  
 