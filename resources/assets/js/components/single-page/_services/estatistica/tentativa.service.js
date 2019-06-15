import { authHeader } from '../../_helpers'; 

 
export const tentativaService = { 
	getUrl, 
	getRank,
};


const url = '/api/v2/tentativa' ;


function getUrl(  ) { 
	return  url; 
}


function getRank(  ) { 
	return  new Promise((resolve, reject) => {
		axios.get( url + '/rank'     , {headers: authHeader() }  )
		.then(response => {    
			resolve( response.data);  
		})
		.catch(error => {  
			reject(error.response);
		}) 
	}); 
}