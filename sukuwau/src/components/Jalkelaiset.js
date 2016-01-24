import React from 'react';
import styles from './styles/Jalkelaiset.css';

export default ({jalkelaiset, urlKey, onClickJalkelainen}) => (
  <div className={styles.container}>
    <div className={styles.header}>Jälkeläiset</div>
    <div className={styles.list}>
      {jalkelaiset.map(({id, data}) => (
        <a className={styles.listItem} key={id} onClick={
          () => {
            onClickJalkelainen(id);
          }
        }>
          {data[urlKey]}
        </a>
      ))}
    </div>
  </div>
);
