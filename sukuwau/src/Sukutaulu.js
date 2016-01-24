import React, { Component } from 'react';
import { connect } from 'react-redux';
import Sukulainen from './Sukulainen';

import styles from './styles/Sukutaulu.css';

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

const mapStateToProps = (state) => ({
  suku: state.horses
});

export class SukutauluUI extends Component {
  render() {
    const { suku } = this.props;
    const maxPituus = suvunPituus(suku);
    let pituus = 4;

    if (pituus > maxPituus) {
      console.error(
        `Haluamasi pituus (${pituus}) ylitti palvelimelta tulleen maksimipituuden (${maxPituus}).`
      );
      pituus = maxPituus;
    }

    return (
      <div className={styles.container}>
        {this._renderHeppa(suku, pituus)}
      </div>
    );
  }

  _renderHeppa(heppa, pituus, polvi = 0, isMother = false) {
    const { name: nimi, father, mother, id } = heppa;

    const key = `${id}-${polvi}-${isMother ? 'm' : 'f'}`;

    if (polvi < pituus + 1) {
      return (
        <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} id={id} key={key}>
          {this._renderHeppa(father || {}, pituus, polvi + 1, false)}
          {this._renderHeppa(mother || {}, pituus, polvi + 1, true)}
        </Sukulainen>
      );
    }
  }
}

export default connect(mapStateToProps)(SukutauluUI);
