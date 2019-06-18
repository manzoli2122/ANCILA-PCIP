import { authHeader } from '../../_helpers'; 

 
export const perguntaService = {
	getPergunta,
	getUrl,
	alterarResposta,
};


const url = '/api/v2/pergunta' ;



function getUrl(  ) { 
	return  url; 
}



function getPergunta( id ) { 
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
  
 

function alterarResposta( id ,  data ) { 
	return  new Promise((resolve, reject) => {
		axios.post( url + '/alterar/resposta/' + id ,  data , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
  