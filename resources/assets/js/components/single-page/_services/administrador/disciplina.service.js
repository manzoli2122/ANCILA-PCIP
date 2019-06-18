import { authHeader } from '../../_helpers'; 

 
export const disciplinaService = {
	getAll , 
	getUrl,
	getDisciplina,
};


const url = '/api/v2/disciplina' ;



function getUrl(  ) { 
	return  url; 
}



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



function getDisciplina( id ) { 
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
 