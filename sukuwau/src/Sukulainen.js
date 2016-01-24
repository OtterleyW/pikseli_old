/* eslint-disable react/no-multi-comp */

import React, { Component, PropTypes as T } from 'react';
import { connect } from 'react-redux';
import { browseHorse } from './actions';

import styles from './styles/Sukulainen.css';

const mapDispatchToProps = (dispatch, props) => ({
  katsoHeppaa: () => dispatch(browseHorse(props.id))
});

const renderHeppa = ({id, nimi, children, polvi, pituus, katsoHeppaa}) => (
  <div className={styles.sukulainen}>
    <div className={styles.heppainfo} onClick={katsoHeppaa}>
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
    nimi: T.string,
    children: T.node,
    polvi: T.number.isRequired,
    pituus: T.number.isRequired,
    katsoHeppaa: T.func.isRequired
  }

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

export default connect(null, mapDispatchToProps)(SukulainenUI);
