import React, { Component, PropTypes as T } from 'react';

import styles from './styles/Sukutaulu.css';

class Sukulainen extends Component {
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

const suvunPituus = (sukuObj, pituus = 0) => {
  const { mother, father } = sukuObj;
  if (mother && father) {
    return Math.max(
      suvunPituus(mother, pituus + 1),
      suvunPituus(father, pituus + 1)
    );
  }
  return pituus;
};

export default class Sukutaulu extends Component {
  render() {
    const { suku } = this.props;
    const pituus = suvunPituus(suku);

    return (
      <div style={{ overflow: 'hidden' }}>
        <div className={styles.container}>
          {this._renderHeppa(suku, pituus)}
        </div>
      </div>
    );
  }

  _renderHeppa(heppa, pituus, polvi = 0) {
    const { name: nimi, father, mother } = heppa;

    if (father && mother) {
      return (
        <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi}>
          {this._renderHeppa(father, pituus, polvi + 1)}
          {this._renderHeppa(mother, pituus, polvi + 1)}
        </Sukulainen>
      );
    }
    else {
      return <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi} />;
    }
  }
}
