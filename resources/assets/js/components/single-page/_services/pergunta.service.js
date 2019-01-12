import { authHeader } from '../_helpers'; 

 
export const perguntaService = {
	getPergunta,
	
};


const url = '/api/v1/pergunta' ;



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
  
 