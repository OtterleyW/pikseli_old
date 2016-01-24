import React, { Component } from 'react';
import { connect } from 'react-redux';
import Sukulainen from './Sukulainen';

import styles from './styles/Sukutaulu.css';

const SUVUN_PITUUS = window.VS_SUKU_PITUUS || 4;

const mapStateToProps = (state) => ({
  suku: state.horses.tree,
  urlKey: state.horses.url_key,
  jalkelaiset: state.horses.descendants
});

export class SukutauluUI extends Component {
  render() {
    const { suku, jalkelaiset } = this.props;

    return (
      <div className={styles.container}>
        {this._renderHeppa(suku, jalkelaiset)}
      </div>
    );
  }

  _renderHeppa(heppa, jalkelaiset, polvi = 0, isMother = false) {
    const { data, url, father, mother, id } = heppa;

    const key = `${id}-${polvi}-${isMother ? 'm' : 'f'}`;

    if (polvi < SUVUN_PITUUS + 1) {
      return (
        <Sukulainen
          data={data}
          url={url}
          polvi={polvi}
          pituus={SUVUN_PITUUS}
          jalkelaiset={jalkelaiset}
          id={id}
          key={key}
        >
          {this._renderHeppa(father || {}, null, polvi + 1, false)}
          {this._renderHeppa(mother || {}, null, polvi + 1, true)}
        </Sukulainen>
      );
    }
  }
}

export default connect(mapStateToProps)(SukutauluUI);
