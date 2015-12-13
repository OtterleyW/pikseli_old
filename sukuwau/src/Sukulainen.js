import React, { Component, PropTypes as T } from 'react';

import styles from './styles/Sukulainen.css';

export default class Sukulainen extends Component {
  static propTypes = {
    nimi: T.string,
    children: T.node,
    polvi: T.number.isRequired,
    pituus: T.number.isRequired
  }

  render() {
    const {nimi, children, polvi, pituus} = this.props;

    return (
      <div className={styles.sukulainen}>
        <div className={styles.heppainfo}>
          <div className={styles.heppa}>
            {nimi}
          </div>
        </div>
        {children &&
          <div
            className={styles.sukuinfo}
            style={{flexGrow: pituus - polvi}}
          >
            {children}
          </div>
        }
      </div>
    );
  }
}
