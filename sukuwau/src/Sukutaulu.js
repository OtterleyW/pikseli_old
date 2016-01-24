import React, { Component } from 'react';
import { connect } from 'react-redux';
import Sukulainen from './Sukulainen';

import styles from './styles/Sukutaulu.css';

const SUVUN_PITUUS = window.VS_SUKU_PITUUS || 4;

const mapStateToProps = (state) => ({
  suku: state.horses.tree
});

export class SukutauluUI extends Component {
  render() {
    const { suku } = this.props;

    return (
      <div className={styles.container}>
        {this._renderHeppa(suku)}
      </div>
    );
  }

  _renderHeppa(heppa, polvi = 0, isMother = false) {
    const { data, father, mother, id } = heppa;

    const key = `${id}-${polvi}-${isMother ? 'm' : 'f'}`;

    if (polvi < SUVUN_PITUUS + 1) {
      return (
        <Sukulainen data={data} polvi={polvi} pituus={SUVUN_PITUUS} id={id} key={key}>
          {this._renderHeppa(father || {}, polvi + 1, false)}
          {this._renderHeppa(mother || {}, polvi + 1, true)}
        </Sukulainen>
      );
    }
  }
}

export default connect(mapStateToProps)(SukutauluUI);
