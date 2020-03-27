import React from 'react';
import { Jumbotron } from 'react-bootstrap';
import './about.css';

const About = () => (
  <div className="about">
    <Jumbotron>
      <h1 className="about__title">maxime quas veniam</h1>
      <pre className="about__content">
        {`
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Omnis alias harum voluptatem nostrum vero mollitia cum,
          voluptas neque praesentium provident quasi, obcaecati enim consequatur illo.
          Hic autem minus aperiam velit.
          Ducimus corrupti iusto officia aperiam eius ad neque sit minima ut
          nostrum aliquideaque qui maxime quas veniam doloremque quaerat repellendus esse,
          rem dolorum tempora perspiciatis impedit?
          Possimus omnis pariatur et quia eum molestiae, sint unde,
          reprehenderit recusandae consequuntur iusto eos quis ipsum veritatis,
          tempore deleniti totam sunt nisi a!
          `}
      </pre>
    </Jumbotron>
  </div>
);


export default About;
