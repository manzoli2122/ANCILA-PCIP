import { authHeader } from '../_helpers'; 

 
export const disciplinaService = {
	getAll , 
};


const url = '/api/v1/disciplina' ;



function getAll(  ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/all'  , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}
  