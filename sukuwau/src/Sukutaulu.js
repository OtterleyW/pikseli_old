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
    const pituus = suvunPituus(suku);

    return (
      <div className={styles.container}>
        {this._renderHeppa(suku, pituus)}
      </div>
    );
  }

  _renderHeppa(heppa, pituus, polvi = 0) {
    const { name: nimi, father, mother, id } = heppa;

    if (father && mother) {
      return (
        <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} id={id} key={id}>
          {this._renderHeppa(father, pituus, polvi + 1)}
          {this._renderHeppa(mother, pituus, polvi + 1)}
        </Sukulainen>
      );
    }
    else {
      return <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} id={id} key={id} />;
    }
  }
}

export default connect(mapStateToProps)(SukutauluUI);
