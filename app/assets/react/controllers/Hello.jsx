import React, { useState, useEffect } from 'react';

const AdvertList = () => {
  const [adverts, setAdverts] = useState([]);

  useEffect(() => {
    const fetchAdverts = async () => {
      try {
        const response = await fetch('localhost:8000/api/adverts'); // Make sure this URL is correct
        const data = await response.json(); // Parse the response data as JSON
        setAdverts(data); 
      } catch (error) {
        console.error('Error fetching adverts:', error);
      }
    };

    fetchAdverts();
  }, []);

  return (
    <div>
      <h1>Adverts List</h1>
      <ul>
        {adverts.map((advert) => (
          <li key={advert.id}>
            <h2>{advert.title}</h2>
            <p>{advert.description}</p>
            {/* Add more advert details here */}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default AdvertList;
