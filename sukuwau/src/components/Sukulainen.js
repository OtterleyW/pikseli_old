/* eslint-disable react/no-multi-comp */

import React, { Component, PropTypes as T } from 'react';
import { connect } from 'react-redux';
import { browseHorse } from '../actions';

import Jalkelaiset from './Jalkelaiset';
import styles from './styles/Sukulainen.css';

const mapStateToProps = (state) => ({
  avaimet: state.horses.keys,
  urlKey: state.horses.url_key,
  descendantKey: state.horses.descendant_key
});

const mapDispatchToProps = (dispatch) => ({
  katsoHeppaa: (id) => dispatch(browseHorse(id))
});

const renderData = ({avaimet, data, url, urlKey}) => (
  avaimet.map((avain) => (
    (url && avain === urlKey) ?
      <a
        className={
          `${styles.url} VS_Sukutaulu__data-${avain}`
        }
        key={avain}
        href={url}
      >
        {data[avain]}
      </a>
      :
      <div className={`VS_Sukutaulu__data-${avain}`} key={avain}>
        {data[avain]}
      </div>
  ))
);

const renderHeppa = ({
  avaimet,
  jalkelaiset,
  id,
  data,
  url,
  urlKey,
  descendantKey,
  children,
  polvi,
  pituus,
  katsoHeppaa
}) => (
  <div className={styles.sukulainen}>
    <div
      className={styles.heppainfo}
      onClick={
        (evt) => { evt.target.tagName === 'A' ? void 0 : katsoHeppaa(id); }
      }
    >
      <div className={styles.heppa}>
        {renderData({avaimet, data, url, urlKey})}
        {(jalkelaiset && jalkelaiset.length) ?
          Jalkelaiset({
            jalkelaiset,
            descendantKey,
            onClickJalkelainen: katsoHeppaa
          }) :
          null
        }
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

const renderTyhja = ({children, pituus, polvi}) => (
  <div className={styles.tyhjaSukulainen}>
    <div className={styles.tyhjaHeppainfo}>
      <div className={styles.tyhjaHeppa}>
        Tuntematon
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

export class SukulainenUI extends Component {
  static propTypes = {
    id: T.oneOfType([T.number, T.string]),
    data: T.object,
    url: T.string,
    children: T.node,
    polvi: T.number.isRequired,
    pituus: T.number.isRequired,
    jalkelaiset: T.array.isRequired,
    katsoHeppaa: T.func.isRequired
  };

  render() {
    const {id} = this.props;

    if (!id) {
      return renderTyhja(this.props);
    }
    else {
      return renderHeppa(this.props);
    }
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(SukulainenUI);
