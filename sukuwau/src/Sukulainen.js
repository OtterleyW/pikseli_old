import React, { Component, PropTypes as T } from 'react';
import { connect } from 'react-redux';
import { browseHorse } from './actions';

import styles from './styles/Sukulainen.css';

const mapDispatchToProps = (dispatch, props) => ({
  katsoHeppaa: () => dispatch(browseHorse(props.id))
});

export class SukulainenUI extends Component {
  static propTypes = {
    id: T.oneOfType([T.number, T.string]).isRequired,
    nimi: T.string,
    children: T.node,
    polvi: T.number.isRequired,
    pituus: T.number.isRequired,
    katsoHeppaa: T.func.isRequired
  }

  render() {
    const {nimi, children, polvi, pituus, katsoHeppaa} = this.props;

    return (
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
  }
}

export default connect(null, mapDispatchToProps)(SukulainenUI);
