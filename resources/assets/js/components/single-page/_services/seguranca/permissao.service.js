import { authHeader } from '../../_helpers'; 

 
export const permissaoService = {
	getPermissao,
	getUrl,  
};


const url = '/api/v2/permissao' ;



function getUrl(  ) { 
	return  url; 
}



function getPermissao( id ) { 
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
  
 
 
 